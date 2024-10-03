<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\PersetujuanPengembangan;
use App\Models\PerencanaanKebutuhan;
use App\Models\FlagStatus;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PerencanaanKebutuhanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nama_proyek_terpakai = PerencanaanKebutuhan::pluck('id_persetujuan_pengembangan')->toArray();
        $trx_persetujuan_pengembangan = PersetujuanPengembangan::whereNotIn('id_persetujuan_pengembangan', $nama_proyek_terpakai)->pluck('nama_proyek', 'id_persetujuan_pengembangan');

        return view('perencanaan_kebutuhan.index',compact('trx_persetujuan_pengembangan'));
    }

    public function data()
    {
        // $trx_perencanaan_kebutuhan = PersetujuanPengembangan::leftJoin('trx_perencanaan_kebutuhan', 'trx_perencanaan_kebutuhan.id_persetujuan_pengembangan', '=', 'trx_persetujuan_pengembangan.id_persetujuan_pengembangan')
        // ->leftJoin('trx_perencanaan_proyek', 'trx_perencanaan_kebutuhan.id_perencanaan_proyek', '=', 'trx_perencanaan_proyek.id_perencanaan_proyek')
        // ->select('persetujuan_pengembangan.*, trx_perencanaan_proyek.*, trx_perencanaan_kebutuhan.*')
        // ->get();
        $trx_perencanaan_kebutuhan = PerencanaanKebutuhan::leftJoin('trx_persetujuan_pengembangan', 'trx_persetujuan_pengembangan.id_persetujuan_pengembangan', '=', 'trx_perencanaan_kebutuhan.id_persetujuan_pengembangan')
        ->join('trx_perencanaan_proyek', function ($join) {
            $join->on('trx_perencanaan_proyek.id_perencanaan_proyek', '=', 'trx_perencanaan_kebutuhan.id_perencanaan_proyek')
            ->orOn('trx_perencanaan_proyek.id_persetujuan_pengembangan', '=', 'trx_perencanaan_kebutuhan.id_persetujuan_pengembangan');
        })
        // ->leftJoin('trx_persetujuan_pengembangan', 'trx_persetujuan_pengembangan.id_persetujuan_pengembangan', '=', 'trx_perencanaan_kebutuhan.id_persetujuan_pengembangan')
        // ->join('trx_persetujuan_pengembangan', function ($join) {
        //     $join->on('trx_persetujuan_pengembangan.id_persetujuan_pengembangan', '=', 'trx_perencanaan_kebutuhan.id_persetujuan_pengembangan')
        //     ->orOn('trx_persetujuan_pengembangan.id_perencanaan_proyek', '=', 'trx_perencanaan_kebutuhan.id_perencanaan_proyek');
        // })
        ->select('trx_perencanaan_kebutuhan.progress', 'trx_perencanaan_kebutuhan.id_perencanaan_kebutuhan', 'trx_perencanaan_kebutuhan.is_approve', 'trx_perencanaan_kebutuhan.kebutuhan_fungsional', 'trx_perencanaan_kebutuhan.kebutuhan_nonfungsional', 'trx_perencanaan_kebutuhan.lampiran', 'trx_perencanaan_kebutuhan.nama_pemohon', 'trx_perencanaan_kebutuhan.jabatan_pemohon', 'trx_perencanaan_kebutuhan.tanggal_disiapkan', 'trx_perencanaan_kebutuhan.nama', 'trx_perencanaan_kebutuhan.jabatan', 'trx_perencanaan_kebutuhan.tanggal_disetujui', 'trx_perencanaan_kebutuhan.file_pdf', 'trx_perencanaan_kebutuhan.stakeholders', 'trx_perencanaan_proyek.nomor_proyek', 'trx_perencanaan_proyek.pemilik_proyek', 'trx_perencanaan_proyek.manajer_proyek', 'trx_persetujuan_pengembangan.nama_proyek', 'trx_persetujuan_pengembangan.deskripsi')
        ->get();

        return datatables()
            ->of($trx_perencanaan_kebutuhan)
            ->addIndexColumn()
            ->addColumn('select_all', function ($trx_perencanaan_kebutuhan) {
                return '
                    <input type="checkbox" name="id_perencanaan_kebutuhan[]" value="'. $trx_perencanaan_kebutuhan->id_perencanaan_kebutuhan .'">
                ';
            })
            ->addColumn('deskripsi', function($trx_perencanaan_kebutuhan){
                return $trx_perencanaan_kebutuhan->deskripsi;
            })
            ->addColumn('pemilik_proyek', function($trx_perencanaan_proyek){
                return $trx_perencanaan_proyek->pemilik_proyek;
            })
            ->addColumn('manajer_proyek', function($trx_perencanaan_proyek){
                return $trx_perencanaan_proyek->manajer_proyek;
            })
            ->addColumn('aksi', function ($trx_perencanaan_kebutuhan) {
                // Cek apakah progress sudah 100% dan file PDF sudah terisi
                $isApproved = $trx_perencanaan_kebutuhan->progress == 100 && !empty($trx_perencanaan_kebutuhan->file_pdf);
                $alreadyApproved = (int) $trx_perencanaan_kebutuhan->is_approve === 1; // Tambahkan kondisi untuk status approval
                // Ubah teks dan tombol berdasarkan kondisi approval
                $approveButton = $alreadyApproved
                    ? '<button type="button" class="btn btn-xs btn-success btn-flat" disabled><i class="fa fa-check"></i> Approved</button>' // Jika sudah di-approve
                    : ($isApproved 
                        ? '<button type="button" onclick="approveProyek(`'. route('perencanaan_kebutuhan.approveProyek', $trx_perencanaan_kebutuhan->id_perencanaan_kebutuhan) .'`)" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-check"></i> Approve</button>'
                        : ''); // Jika belum memenuhi syarat approval, tampilkan tombol Approve

                return '
                <div class="btn-group">
                    <button onclick="deleteData(`'. route('perencanaan_kebutuhan.destroy', $trx_perencanaan_kebutuhan->id_perencanaan_kebutuhan) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                    ' . (!$isApproved ? '
                    <button onclick="editForm(`'. route('perencanaan_kebutuhan.update', $trx_perencanaan_kebutuhan->id_perencanaan_kebutuhan) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="UploadPDF(`'. route('perencanaan_kebutuhan.updatePDF', $trx_perencanaan_kebutuhan->id_perencanaan_kebutuhan) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-upload"></i></button>
                    <button onclick="updateProgressForm(`'. route('perencanaan_kebutuhan.editProgress', $trx_perencanaan_kebutuhan->id_perencanaan_kebutuhan) .'`)" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-tasks"></i> Update Progress</button>
                    ' : '') . '
                    '. $approveButton .'
                    <button onclick="cetakDokumen(`'.route('perencanaan_kebutuhan.cetakDokumen', $trx_perencanaan_kebutuhan->id_perencanaan_kebutuhan) .'`)" class="btn btn-info btn-xs btn-flat">
                        <i class="fa fa-download"></i> Cetak Dokumen
                    </button>
                    <button onclick="viewForm(`'. route('perencanaan_kebutuhan.view', $trx_perencanaan_kebutuhan->id_perencanaan_kebutuhan) .'`)" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-eye"></i></button>
                </div>
                ';
            })
            ->addColumn('file_pdf', function ($trx_perencanaan_kebutuhan) {
                if ($trx_perencanaan_kebutuhan->file_pdf) {
                    return '<a href="/storage/assets/pdf/' . $trx_perencanaan_kebutuhan->file_pdf . '" target="_blank">Lihat PDF</a>';
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
                        LEFT JOIN trx_perencanaan_proyek AS tpp3 ON tpp3.id_persetujuan_pengembangan = tpp2.id_persetujuan_pengembangan 
                        WHERE tpp2.id_persetujuan_pengembangan = $request->id_persetujuan_pengembangan AND tpp3.progress = 100 AND tpp3.is_approve = 1
                        GROUP BY 
                            flag_status.id_permintaan, 
                            tpp.nomor_dokumen, 
                            tpp.latar_belakang, 
                            tpp.tujuan
                        HAVING 
                            MAX(flag_status.flag) = 3;
                        ";

        $result = DB::select($sql_validasi);

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('assets/lampiran', $filename, 'public');

            $data['lampiran'] = $filename;
        }

        if (count($result) > 0) {
            if ($request->hasFile('file_pdf')) {
                $file = $request->file('file_pdf');
                $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('assets/pdf', $filename, 'public');
                $data['file_pdf'] = $filename;
            }

            $trx_perencanaan_kebutuhan = PerencanaanKebutuhan::create($data);
            $lastId = $trx_perencanaan_kebutuhan->id_perencanaan_kebutuhan;
            $id_persetujuan_pengembangan = $trx_perencanaan_kebutuhan->id_persetujuan_pengembangan;

            $id_permintaan_pengembangan  = DB::table('trx_perencanaan_kebutuhan as tpk')
                                            ->join('trx_persetujuan_pengembangan as b', 'b.id_persetujuan_pengembangan', '=', 'tpk.id_persetujuan_pengembangan')
                                            ->where('tpk.id_persetujuan_pengembangan', $id_persetujuan_pengembangan)
                                            ->select('b.id_permintaan_pengembangan')
                                            ->first(); // Mengambil satu hasil 

            $id_permintaan_pengembangan = $id_permintaan_pengembangan->id_permintaan_pengembangan;

            FlagStatus::create([
                'kat_modul' => 4,
                'id_permintaan' => $id_permintaan_pengembangan,
                'nama_modul' => "Perencanaan Kebutuhan",
                'id_tabel' => $lastId,
                'flag' => 4
            ]);

            return response()->json('Data berhasil disimpan', 200);
        }else{
            echo "Tambah Data Gagal, Karena Anda Melewati Tahapan Sebelumnya atau Progress Belum 100%";
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
        $trx_perencanaan_kebutuhan = PerencanaanKebutuhan::leftJoin('trx_persetujuan_pengembangan', 'trx_persetujuan_pengembangan.id_persetujuan_pengembangan', '=', 'trx_perencanaan_kebutuhan.id_persetujuan_pengembangan')
            ->join('trx_perencanaan_proyek', function ($join) {
                $join->on('trx_perencanaan_proyek.id_perencanaan_proyek', '=', 'trx_perencanaan_kebutuhan.id_perencanaan_proyek')
                    ->orOn('trx_perencanaan_proyek.id_persetujuan_pengembangan', '=', 'trx_perencanaan_kebutuhan.id_persetujuan_pengembangan');
            })
            ->select([
                'trx_perencanaan_kebutuhan.id_perencanaan_kebutuhan', 
                'trx_perencanaan_kebutuhan.kebutuhan_fungsional', 
                'trx_perencanaan_kebutuhan.kebutuhan_nonfungsional', 
                'trx_perencanaan_kebutuhan.lampiran', 
                'trx_perencanaan_kebutuhan.nama_pemohon', 
                'trx_perencanaan_kebutuhan.jabatan_pemohon', 
                'trx_perencanaan_kebutuhan.tanggal_disiapkan', 
                'trx_perencanaan_kebutuhan.nama', 
                'trx_perencanaan_kebutuhan.jabatan', 
                'trx_perencanaan_kebutuhan.tanggal_disetujui', 
                'trx_perencanaan_kebutuhan.file_pdf', 
                'trx_perencanaan_kebutuhan.stakeholders', 
                'trx_perencanaan_proyek.nomor_proyek', 
                'trx_perencanaan_proyek.pemilik_proyek', 
                'trx_perencanaan_proyek.manajer_proyek', 
                'trx_persetujuan_pengembangan.nama_proyek', 
                'trx_persetujuan_pengembangan.deskripsi'
            ])
            ->where('trx_perencanaan_kebutuhan.id_perencanaan_kebutuhan', $id) // Menggunakan kondisi where pada id_perencanaan_proyek
            ->first(); // Mengambil satu hasil pertama dari query
        
        return response()->json($trx_perencanaan_kebutuhan);
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
    public function update(Request $request, $id_perencanaan_kebutuhan)
    {
        $trx_perencanaan_kebutuhan = PerencanaanKebutuhan::findOrFail($id_perencanaan_kebutuhan);
        $data = $request->all();
        var_dump($data);
        die;

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');

            $path = $file->storeAs('assets/lampiran', $file->getClientOriginalName(), 'public');

            $data['lampiran'] = 'storage/' . $path;
        }

        $trx_perencanaan_kebutuhan->update($data);
        return response()->json('Data berhasil diperbarui', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trx_perencanaan_kebutuhan = PerencanaanKebutuhan::find($id);
        $trx_perencanaan_kebutuhan->delete();

        return response(null, 204);
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->id_perencanaan_kebutuhan;
        PerencanaanKebutuhan::whereIn('id_perencanaan_kebutuhan', $ids)->delete();
        return response()->json('Data berhasil dihapus', 200);
    }

    public function cetakDokumen(Request $request)
    {
        set_time_limit(300);

        $idPerencanaanKebutuhan = $request->query();
        $id_perencanaan_kebutuhan = key($idPerencanaanKebutuhan); 
        $id_perencanaan_kebutuhan = (int) $id_perencanaan_kebutuhan;


        $datakebutuhan = PerencanaanKebutuhan::whereIn('id_perencanaan_kebutuhan', [$id_perencanaan_kebutuhan])->get();
        $no  = 1;
        $pdf = PDF::loadView('perencanaan_kebutuhan.dokumen', compact('datakebutuhan', 'no'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('PerencanaanKebutuhan.pdf');
    }

    public function view($id)
    {
        $trx_perencanaan_kebutuhan = PerencanaanKebutuhan::findOrFail($id);
        return response()->json($trx_perencanaan_kebutuhan);
    }

    
    public function updatePDF(Request $request, $id_perencanaan_kebutuhan)
    {
        // Temukan data berdasarkan ID
        $trx_perencanaan_kebutuhan = PerencanaanKebutuhan::findOrFail($id_perencanaan_kebutuhan);

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
            $trx_perencanaan_kebutuhan->file_pdf = $filename;

            // Update data di database
            $trx_perencanaan_kebutuhan->save();

            return response()->json('File PDF berhasil diperbarui', 200);
        }

        return response()->json('Tidak ada file yang diupload', 400);
    }

    // For Update Progress Project
    public function editProgress($id)
    {
        // Cari data permintaan pengembangan berdasarkan ID
        $trx_perencanaan_kebutuhan = PerencanaanKebutuhan::leftJoin('trx_persetujuan_pengembangan', 'trx_persetujuan_pengembangan.id_persetujuan_pengembangan', '=', 'trx_perencanaan_kebutuhan.id_persetujuan_pengembangan')
            ->join('trx_perencanaan_proyek', function ($join) {
                $join->on('trx_perencanaan_proyek.id_perencanaan_proyek', '=', 'trx_perencanaan_kebutuhan.id_perencanaan_proyek')
                ->orOn('trx_perencanaan_proyek.id_persetujuan_pengembangan', '=', 'trx_perencanaan_kebutuhan.id_persetujuan_pengembangan');
            })
            // ->leftJoin('trx_persetujuan_pengembangan', 'trx_persetujuan_pengembangan.id_persetujuan_pengembangan', '=', 'trx_perencanaan_kebutuhan.id_persetujuan_pengembangan')
            // ->join('trx_persetujuan_pengembangan', function ($join) {
            //     $join->on('trx_persetujuan_pengembangan.id_persetujuan_pengembangan', '=', 'trx_perencanaan_kebutuhan.id_persetujuan_pengembangan')
            //     ->orOn('trx_persetujuan_pengembangan.id_perencanaan_proyek', '=', 'trx_perencanaan_kebutuhan.id_perencanaan_proyek');
            // })
            ->select('trx_perencanaan_kebutuhan.id_perencanaan_kebutuhan', 'trx_persetujuan_pengembangan.nama_proyek', 'trx_perencanaan_kebutuhan.kebutuhan_fungsional', 'trx_perencanaan_kebutuhan.kebutuhan_nonfungsional', 'trx_perencanaan_kebutuhan.lampiran', 'trx_perencanaan_kebutuhan.nama_pemohon', 'trx_perencanaan_kebutuhan.jabatan_pemohon', 'trx_perencanaan_kebutuhan.tanggal_disiapkan', 'trx_perencanaan_kebutuhan.nama', 'trx_perencanaan_kebutuhan.jabatan', 'trx_perencanaan_kebutuhan.tanggal_disetujui', 'trx_perencanaan_kebutuhan.file_pdf', 'trx_perencanaan_kebutuhan.stakeholders', 'trx_perencanaan_proyek.nomor_proyek', 'trx_perencanaan_proyek.pemilik_proyek', 'trx_perencanaan_proyek.manajer_proyek', 'trx_persetujuan_pengembangan.nama_proyek', 'trx_persetujuan_pengembangan.deskripsi', 'trx_perencanaan_kebutuhan.progress')
            ->where('trx_perencanaan_kebutuhan.id_perencanaan_kebutuhan', $id)
            ->first();

        // Kirim data ke response JSON
        return response()->json($trx_perencanaan_kebutuhan);
    }

    public function updateProgress(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'progress' => 'required|integer|min:0|max:100', // Validasi progress
            'nama_proyek' => 'required|string|max:255', // Validasi nomor dokumen
        ]);

        // Cari data permintaan pengembangan berdasarkan ID
        $trx_perencanaan_kebutuhan = PerencanaanKebutuhan::findOrFail($id);

        // Update progress
        $trx_perencanaan_kebutuhan->progress = $request->progress; // Pastikan ada kolom 'progress' di tabel
        $trx_perencanaan_kebutuhan->save(); // Simpan perubahan

        // Kembali dengan respon sukses
        return redirect()->route('perencanaan_kebutuhan.index');
    }

    // Method untuk melakukan approve proyek
    public function approveProyek($id)
    {
        // Ambil data proyek berdasarkan id
        $proyek = PerencanaanKebutuhan::findOrFail($id);

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
