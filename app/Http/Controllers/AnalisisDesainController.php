<?php

namespace App\Http\Controllers;

use App\Models\AnalisisDesain;
use App\Models\PerencanaanProyek;
use App\Models\PermintaanPengembangan;
use App\Models\FlagStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AnalisisDesainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nama_permintaan_terpakai = AnalisisDesain::pluck('id_permintaan_pengembangan')->toArray();
        // $trx_permintaan_pengembangan = PermintaanPengembangan::whereNotIn('id_permintaan_pengembangan', $nama_permintaan_terpakai)->pluck('nomor_dokumen', 'id_permintaan_pengembangan');
        $trx_permintaan_pengembangan = PermintaanPengembangan::leftJoin('trx_persetujuan_pengembangan', 'trx_permintaan_pengembangan.id_permintaan_pengembangan', '=', 'trx_persetujuan_pengembangan.id_permintaan_pengembangan')
        ->whereNotIn('trx_permintaan_pengembangan.id_permintaan_pengembangan', $nama_permintaan_terpakai)
        ->whereIn('trx_permintaan_pengembangan.id_permintaan_pengembangan', function ($query) {
            $query->select('id_permintaan_pengembangan')
                ->from('trx_persetujuan_pengembangan');
        })
        ->pluck('trx_permintaan_pengembangan.nomor_dokumen', 'trx_permintaan_pengembangan.id_permintaan_pengembangan');
        
        return view('analisis_desain.index', compact('trx_permintaan_pengembangan'));
    }

    public function data()
    {
        $trx_analisis_desain = AnalisisDesain::leftJoin('trx_permintaan_pengembangan', 'trx_permintaan_pengembangan.id_permintaan_pengembangan', '=', 'trx_analisis_desain.id_permintaan_pengembangan')
        ->leftJoin('trx_persetujuan_pengembangan', 'trx_persetujuan_pengembangan.id_permintaan_pengembangan', '=', 'trx_permintaan_pengembangan.id_permintaan_pengembangan')
        ->select(
            'trx_analisis_desain.id_analisis_desain', 
            'trx_persetujuan_pengembangan.nama_proyek', 
            'trx_analisis_desain.deskripsi_proyek', 
            'trx_analisis_desain.manajer_proyek',
            'trx_analisis_desain.kebutuhan_fungsi',
            'trx_analisis_desain.gambaran_arsitektur',
            'trx_analisis_desain.detil_arsitektur',
            'trx_analisis_desain.lampiran_mockup',
            'trx_analisis_desain.nama_pemohon',
            'trx_analisis_desain.jabatan_pemohon',
            'trx_analisis_desain.tanggal_disiapkan',
            'trx_analisis_desain.nama',
            'trx_analisis_desain.jabatan',
            'trx_analisis_desain.tanggal_disetujui',
            'trx_analisis_desain.status',
            'trx_analisis_desain.file_pdf',
            'trx_analisis_desain.progress',
            'trx_analisis_desain.is_approve',
        )
        ->get();

        return datatables()
            ->of($trx_analisis_desain)
            ->addIndexColumn()
            ->addColumn('select_all', function ($trx_analisis_desain) {
                return '
                    <input type="checkbox" name="id_analisis_desain[]" value="'. $trx_analisis_desain->id_analisis_desain .'">
                ';
            })
            ->addColumn('aksi', function ($trx_analisis_desain) {
                // Cek apakah progress sudah 100% dan file PDF sudah terisi
                $isApproved = $trx_analisis_desain->progress == 100 && !empty($trx_analisis_desain->file_pdf);
                $alreadyApproved = (int) $trx_analisis_desain->is_approve === 1; // Tambahkan kondisi untuk status approval
                // Ubah teks dan tombol berdasarkan kondisi approval
                $approveButton = $alreadyApproved
                    ? '<button type="button" class="btn btn-xs btn-success btn-flat" disabled><i class="fa fa-check"></i> Approved</button>' // Jika sudah di-approve
                    : ($isApproved 
                        ? '<button type="button" onclick="approveProyek(`'. route('analisis_desain.approveProyek', $trx_analisis_desain->id_analisis_desain) .'`)" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-check"></i> Approve</button>'
                        : ''); // Jika belum memenuhi syarat approval, tampilkan tombol Approve

                return '
                <div class="btn-group">
                    <button onclick="deleteData(`'. route('analisis_desain.destroy', $trx_analisis_desain->id_analisis_desain) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                    ' . (!$isApproved ? '
                    <button onclick="editForm(`'. route('analisis_desain.update', $trx_analisis_desain->id_analisis_desain) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="UploadPDF(`'. route('analisis_desain.updatePDF', $trx_analisis_desain->id_analisis_desain) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-upload"></i></button>
                    <button onclick="updateProgressForm(`'. route('analisis_desain.editProgress', $trx_analisis_desain->id_analisis_desain) .'`)" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-tasks"></i> Update Progress</button>
                    ' : '') . '
                    '. $approveButton .'
                    <button onclick="viewForm(`'. route('analisis_desain.view', $trx_analisis_desain->id_analisis_desain) .'`)" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-eye"></i></button>
                </div>
                ';
            })
            ->addColumn('file_pdf', function ($trx_analisis_desain) {
                if ($trx_analisis_desain->file_pdf) {
                    return '<a href="/storage/assets/pdf/' . $trx_analisis_desain->file_pdf . '" target="_blank">Lihat PDF</a>';
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
                        LEFT JOIN trx_permintaan_pengembangan AS tpp ON tpp.id_permintaan_pengembangan 
                            = flag_status.id_permintaan
                        LEFT JOIN trx_persetujuan_pengembangan AS tpp2 ON tpp2.id_permintaan_pengembangan 
                                = tpp.id_permintaan_pengembangan
                        LEFT JOIN trx_perencanaan_kebutuhan AS tpk ON tpk.id_persetujuan_pengembangan 
                                = tpp2.id_persetujuan_pengembangan
                        WHERE id_permintaan = $request->id_permintaan_pengembangan AND tpk.progress = 100 AND tpk.is_approve = 1
                        GROUP BY 
                            flag_status.id_permintaan, 
                            tpp.nomor_dokumen, 
                            tpp.latar_belakang, 
                            tpp.tujuan
                        HAVING 
                            MAX(flag_status.flag) = 4;
                        ";

        $result = DB::select($sql_validasi);

        
        if ($request->hasFile('file_pdf')) {
            $file = $request->file('file_pdf');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('assets/pdf', $filename, 'public');
            $data['file_pdf'] = $filename;
        }

        if (count($result) > 0) {
            $trx_analisis_desain = AnalisisDesain::create($data);
            $id_permintaan_pengembangan = $trx_analisis_desain->id_permintaan_pengembangan;
            $lastId = $trx_analisis_desain->id_analisis_desain;

            FlagStatus::create([
                'kat_modul' => 5,
                'id_permintaan' => $id_permintaan_pengembangan,
                'nama_modul' => "Analisis Desain",
                'id_tabel' => $lastId,
                'flag' => 5
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
    public function show($id_analisis_desain)
    {
        $trx_analisis_desain = AnalisisDesain::find($id_analisis_desain);

        return response()->json($trx_analisis_desain);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_analisis_desain)
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
    public function update(Request $request, $id_analisis_desain)
    {
        $trx_analisis_desain = AnalisisDesain::find($id_analisis_desain)->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_analisis_desain)
    {
        $trx_analisis_desain = AnalisisDesain::find($id_analisis_desain);
        $trx_analisis_desain->delete();

        return response(null, 204);
    }

    public function cetakDokumen(Request $request)
    {
        set_time_limit(300);

        $dataanalisis = AnalisisDesain::whereIn('id_analisis_desain', $request->id_analisis_desain)->get();
        $no  = 1;

        $pdf = PDF::loadView('analisis_desain.dokumen', compact('dataanalisis', 'no'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('analisis.pdf');
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->id_analisis_desain;
        AnalisisDesain::whereIn('id_analisis_desain', $ids)->delete();
        return response()->json('Data berhasil dihapus', 200);
    }

    public function view($id)
    {
        $trx_analisis_desain = AnalisisDesain::leftJoin('trx_permintaan_pengembangan', 'trx_permintaan_pengembangan.id_permintaan_pengembangan', '=', 'trx_analisis_desain.id_permintaan_pengembangan')
        ->leftJoin('trx_persetujuan_pengembangan', 'trx_persetujuan_pengembangan.id_permintaan_pengembangan', '=', 'trx_permintaan_pengembangan.id_permintaan_pengembangan')
        ->select(
            'trx_analisis_desain.id_analisis_desain', 
            'trx_persetujuan_pengembangan.nama_proyek', 
            'trx_analisis_desain.deskripsi_proyek', 
            'trx_analisis_desain.manajer_proyek',
            'trx_analisis_desain.kebutuhan_fungsi',
            'trx_analisis_desain.gambaran_arsitektur',
            'trx_analisis_desain.detil_arsitektur',
            'trx_analisis_desain.lampiran_mockup',
            'trx_analisis_desain.nama_pemohon',
            'trx_analisis_desain.jabatan_pemohon',
            'trx_analisis_desain.tanggal_disiapkan',
            'trx_analisis_desain.nama',
            'trx_analisis_desain.jabatan',
            'trx_analisis_desain.tanggal_disetujui',
            'trx_analisis_desain.status',
            'trx_analisis_desain.file_pdf'
        )
        ->where('trx_analisis_desain.id_analisis_desain', $id) // Menggunakan kondisi where pada id_perencanaan_proyek
        ->first(); // Mengambil satu hasil pertama dari query

        return response()->json($trx_analisis_desain);
    }

    public function updatePDF(Request $request, $id_analisis_desain)
    {
        // Temukan data berdasarkan ID
        $trx_analisis_desain = AnalisisDesain::findOrFail($id_analisis_desain);

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
            $trx_analisis_desain->file_pdf = $filename;

            // Update data di database
            $trx_analisis_desain->save();

            return response()->json('File PDF berhasil diperbarui', 200);
        }

        return response()->json('Tidak ada file yang diupload', 400);
    }

    // For Update Progress Project
    public function editProgress($id)
    {
        $trx_analisis_desain = AnalisisDesain::leftJoin('trx_permintaan_pengembangan', 'trx_permintaan_pengembangan.id_permintaan_pengembangan', '=', 'trx_analisis_desain.id_permintaan_pengembangan')
            ->leftJoin('trx_persetujuan_pengembangan', 'trx_persetujuan_pengembangan.id_permintaan_pengembangan', '=', 'trx_permintaan_pengembangan.id_permintaan_pengembangan')
            ->select(
                'trx_analisis_desain.id_analisis_desain', 
                'trx_permintaan_pengembangan.nomor_dokumen', 
                'trx_persetujuan_pengembangan.nama_proyek', 
                'trx_analisis_desain.deskripsi_proyek', 
                'trx_analisis_desain.manajer_proyek',
                'trx_analisis_desain.kebutuhan_fungsi',
                'trx_analisis_desain.gambaran_arsitektur',
                'trx_analisis_desain.detil_arsitektur',
                'trx_analisis_desain.lampiran_mockup',
                'trx_analisis_desain.nama_pemohon',
                'trx_analisis_desain.jabatan_pemohon',
                'trx_analisis_desain.tanggal_disiapkan',
                'trx_analisis_desain.nama',
                'trx_analisis_desain.jabatan',
                'trx_analisis_desain.tanggal_disetujui',
                'trx_analisis_desain.status',
                'trx_analisis_desain.progress',
                'trx_analisis_desain.file_pdf',
            )
            ->where('trx_analisis_desain.id_analisis_desain', $id)
            ->first();

        // Kirim data ke response JSON
        return response()->json($trx_analisis_desain);
    }

    public function updateProgress(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'progress' => 'required|integer|min:0|max:100', // Validasi progress
            'nomor_dokumen' => 'required|string|max:255', // Validasi nomor dokumen
        ]);

        // Cari data permintaan pengembangan berdasarkan ID
        $trx_analisis_desain = AnalisisDesain::findOrFail($id);

        // Update progress
        $trx_analisis_desain->progress = $request->progress; // Pastikan ada kolom 'progress' di tabel
        $trx_analisis_desain->save(); // Simpan perubahan

        // Kembali dengan respon sukses
        return redirect()->route('analisis_desain.index');
    }

    // Method untuk melakukan approve proyek
    public function approveProyek($id)
    {
        // Ambil data proyek berdasarkan id
        $proyek = AnalisisDesain::findOrFail($id);

        // Cek apakah progress sudah 100% dan file_pdf sudah terisi
        if ($proyek->progress == 100 && !empty($proyek->file_pdf)) {
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