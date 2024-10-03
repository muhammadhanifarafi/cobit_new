<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\QualityAssuranceTesting;
use App\Models\PermintaanPengembangan;
use Illuminate\Support\Facades\DB;
use App\Models\FlagStatus;
use Barryvdh\DomPDF\Facade\Pdf;

class QualityAssuranceTestingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nama_permintaan_terpakai = QualityAssuranceTesting::pluck('id_permintaan_pengembangan')->toArray();
        // $trx_permintaan_pengembangan = PermintaanPengembangan::whereNotIn('id_permintaan_pengembangan', $nama_permintaan_terpakai)->pluck('nomor_dokumen', 'id_permintaan_pengembangan');
        $trx_permintaan_pengembangan = PermintaanPengembangan::leftJoin('trx_persetujuan_pengembangan', 'trx_permintaan_pengembangan.id_permintaan_pengembangan', '=', 'trx_persetujuan_pengembangan.id_permintaan_pengembangan')
        ->whereNotIn('trx_permintaan_pengembangan.id_permintaan_pengembangan', $nama_permintaan_terpakai)
        ->whereIn('trx_permintaan_pengembangan.id_permintaan_pengembangan', function ($query) {
            $query->select('id_permintaan_pengembangan')
                ->from('trx_persetujuan_pengembangan');
        })
        ->pluck('trx_permintaan_pengembangan.nomor_dokumen', 'trx_permintaan_pengembangan.id_permintaan_pengembangan');
        
        return view('quality_assurance_testing.index', compact('trx_permintaan_pengembangan'));
    }

    public function data()
    {
        // $trx_quality_assurance_testing = QualityAssuranceTesting::orderBy('id_quality_assurance_testing', 'desc')->get();

        $trx_quality_assurance_testing = QualityAssuranceTesting::leftJoin('trx_permintaan_pengembangan', 'trx_permintaan_pengembangan.id_permintaan_pengembangan', '=', 'trx_quality_assurance_testing.id_permintaan_pengembangan')
        ->leftJoin('trx_persetujuan_pengembangan', 'trx_persetujuan_pengembangan.id_permintaan_pengembangan', '=', 'trx_permintaan_pengembangan.id_permintaan_pengembangan')
        ->select(
            'trx_quality_assurance_testing.*',
            'trx_permintaan_pengembangan.id_permintaan_pengembangan',
        )
        ->get();

        return datatables()
            ->of($trx_quality_assurance_testing)
            ->addIndexColumn()
            ->addColumn('select_all', function ($trx_quality_assurance_testing) {
                return '
                    <input type="checkbox" name="id_quality_assurance_testing[]" value="'. $trx_quality_assurance_testing->id_quality_assurance_testing .'">
                ';
            })
            ->addColumn('aksi', function ($trx_quality_assurance_testing) {
                // Cek apakah progress sudah 100% dan file PDF sudah terisi
                $isApproved = $trx_quality_assurance_testing->progress == 100;
                // && !empty($trx_quality_assurance_testing->file_pdf);
                $alreadyApproved = (int) $trx_quality_assurance_testing->is_approve === 1; // Tambahkan kondisi untuk status approval
                // Ubah teks dan tombol berdasarkan kondisi approval
                $approveButton = $alreadyApproved
                    ? '<button type="button" class="btn btn-xs btn-success btn-flat" disabled><i class="fa fa-check"></i> Approved</button>' // Jika sudah di-approve
                    : ($isApproved 
                        ? '<button type="button" onclick="approveProyek(`'. route('quality_assurance_testing.approveProyek', $trx_quality_assurance_testing->id_quality_assurance_testing) .'`)" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-check"></i> Approve</button>'
                        : ''); // Jika belum memenuhi syarat approval, tampilkan tombol Approve

                return '
                <div class="btn-group">
                    <button onclick="deleteData(`'. route('quality_assurance_testing.destroy', $trx_quality_assurance_testing->id_quality_assurance_testing) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                    ' . (!$isApproved ? '
                    <button onclick="editForm(`'. route('quality_assurance_testing.update', $trx_quality_assurance_testing->id_quality_assurance_testing) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="updateProgressForm(`'. route('quality_assurance_testing.editProgress', $trx_quality_assurance_testing->id_quality_assurance_testing) .'`)" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-tasks"></i> Update Progress</button>
                    <button onclick="UploadPDF(`'. route('quality_assurance_testing.updatePDF', $trx_quality_assurance_testing->id_quality_assurance_testing) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-upload"></i></button>
                    ' : '') . '
                    '. $approveButton .'
                </div>
                ';
            })
            ->addColumn('file_pdf', function ($trx_quality_assurance_testing) {
                if ($trx_quality_assurance_testing->file_pdf) {
                    return '<a href="/storage/assets/pdf/' . $trx_quality_assurance_testing->file_pdf . '" target="_blank">Lihat PDF</a>';
                }
                return '-';
            })
            ->rawColumns(['aksi', 'select_all','file_pdf'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // Cek Validasi Sudah Pengisian Tahap Sebelumnya atau Belum
        $sql_validasi = "SELECT 
                            flag_status.id_permintaan, 
                            tpp.nomor_dokumen, 
                            tpp.latar_belakang, 
                            tpp.tujuan, 
                            MAX(flag_status.flag) AS max_flag
                        FROM 
                            flag_status
                        LEFT JOIN trx_permintaan_pengembangan AS tpp ON tpp.id_permintaan_pengembangan = flag_status.id_permintaan
                        LEFT JOIN trx_user_acceptance_testing AS tuat ON tuat.id_permintaan_pengembangan = tpp.id_permintaan_pengembangan
                        WHERE id_permintaan = $request->id_permintaan_pengembangan AND tuat.progress = 100 AND tuat.is_approve = 1
                        GROUP BY 
                            flag_status.id_permintaan, 
                            tpp.nomor_dokumen, 
                            tpp.latar_belakang, 
                            tpp.tujuan
                        HAVING 
                            MAX(flag_status.flag) = 6;
                        ";

        $result = DB::select($sql_validasi);

        if ($request->hasFile('file_pdf')) {
            $file = $request->file('file_pdf');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('assets/pdf', $filename, 'public');
            $data['file_pdf'] = $filename;
        }

        if (count($result) > 0) {
            $trx_quality_assurance_testing = QualityAssuranceTesting::create($data);
            $id_permintaan_pengembangan = $trx_quality_assurance_testing->id_permintaan_pengembangan;
            $lastId = $trx_quality_assurance_testing->id_quality_assurance_testing;

            FlagStatus::create([
                'kat_modul' => 7,
                'id_permintaan' => $id_permintaan_pengembangan,
                'nama_modul' => "Quality Assurance Testing",
                'id_tabel' => $lastId,
                'flag' => 7
            ]);

            return response()->json('Data berhasil disimpan', 200);
        }else{
            echo "Tambah Data Gagal, Karena Anda Melewati Tahapan Sebelumnya";
            die;
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trx_quality_assurance_testing = QualityAssuranceTesting::find($id);

        return response()->json($trx_quality_assurance_testing);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_quality_assurance_testing)
    {
        $trx_quality_assurance_testing = QualityAssuranceTesting::find($id_quality_assurance_testing)->update($request->all());

        return response()->json('Data berhasil diperbarui', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_quality_assurance_testing)
    {
        $trx_quality_assurance_testing = QualityAssuranceTesting::find($id_quality_assurance_testing);
        $trx_quality_assurance_testing->delete();

        return response(null, 204);
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->id_quality_assurance_testing;
        QualityAssuranceTesting::whereIn('id_quality_assurance_testing', $ids)->delete();
        return response()->json('Data berhasil dihapus', 200);
    }

    public function cetakDokumen(Request $request)
    {
        set_time_limit(300);

        $dataQAT = QualityAssuranceTesting::whereIn('id_quality_assurance_testing', $request->id_quality_assurance_testing)->get();
        $no  = 1;

        $pdf = PDF::loadView('quality_assurance_testing.dokumen', compact('dataQAT', 'no'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('Quality Assurance Testing (QAT).pdf');
    }

    public function updatePDF(Request $request, $id_quality_assurance_testing)
    {
        // Temukan data berdasarkan ID
        $trx_quality_assurance_testing = QualityAssuranceTesting::findOrFail($id_quality_assurance_testing);

        // Validasi input file
        $request->validate([
            'file_pdf' => 'required|file|mimes:pdf|max:2048', // Aturan validasi untuk file PDF
        ]);

        // Periksa apakah ada file PDF yang diupload
        if ($request->hasFile('file_pdf')) {
            $file = $request->file('file_pdf');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('assets/pdf', $filename, 'public');

            // Simpan nama file baru ke kolom `file_pdf`
            $trx_quality_assurance_testing->file_pdf = $filename;

            // Update data di database
            $trx_quality_assurance_testing->save();

            return response()->json('File PDF berhasil diperbarui', 200);
        }

        return response()->json('Tidak ada file yang diupload', 400);
    }

    // For Update Progress Project
    public function editProgress($id)
    {
        $trx_quality_assurance_testing = QualityAssuranceTesting::leftJoin('trx_permintaan_pengembangan', 'trx_permintaan_pengembangan.id_permintaan_pengembangan', '=', 'trx_quality_assurance_testing.id_permintaan_pengembangan')
        ->leftJoin('trx_persetujuan_pengembangan', 'trx_persetujuan_pengembangan.id_permintaan_pengembangan', '=', 'trx_permintaan_pengembangan.id_permintaan_pengembangan')
        ->select(
            'trx_quality_assurance_testing.*',
            'trx_permintaan_pengembangan.id_permintaan_pengembangan',
            'trx_permintaan_pengembangan.nomor_dokumen',
        )
        ->where('trx_quality_assurance_testing.id_quality_assurance_testing', $id)
        ->first();

        // Kirim data ke response JSON
        return response()->json($trx_quality_assurance_testing);
    }

    public function updateProgress(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'progress' => 'required|integer|min:0|max:100', // Validasi progress
            'nomor_dokumen' => 'required|string|max:255', // Validasi nomor dokumen
        ]);

        // Cari data permintaan pengembangan berdasarkan ID
        $trx_quality_assurance_testing = QualityAssuranceTesting::findOrFail($id);

        // Update progress
        $trx_quality_assurance_testing->progress = $request->progress; // Pastikan ada kolom 'progress' di tabel
        $trx_quality_assurance_testing->save(); // Simpan perubahan

        // Kembali dengan respon sukses
        return redirect()->route('quality_assurance_testing.index');
    }

    // Method untuk melakukan approve proyek
    public function approveProyek($id)
    {
        // Ambil data proyek berdasarkan id
        $proyek = QualityAssuranceTesting::findOrFail($id);

        // Cek apakah progress sudah 100% dan file_pdf sudah terisi
        // if ($proyek->progress == 100 && !empty($proyek->file_pdf)) {
        if ($proyek->progress == 100) {
            // Update status proyek menjadi approved (Anda dapat menambah field status_approval di tabel)
            $proyek->is_approve = 1;
            $proyek->approve_at = now(); // Set tanggal persetujuan saat ini
            $proyek->approve_by = auth()->user()->name; // Set tanggal persetujuan saat ini
            $proyek->save();

            return response()->json(['success' => 'Proyek berhasil di-approve.']);
        }

        // Jika belum memenuhi syarat approval, kembalikan pesan error
        return response()->json(['error' => 'Proyek belum memenuhi syarat untuk di-approve.'], 400);
    }
}
