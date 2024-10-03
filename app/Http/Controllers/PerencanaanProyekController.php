<?php

namespace App\Http\Controllers;

use App\Models\PersetujuanPengembangan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\PerencanaanProyek;
use App\Models\FlagStatus;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PerencanaanProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nama_proyek_terpakai = PerencanaanProyek::pluck('id_persetujuan_pengembangan')->toArray();
        $trx_persetujuan_pengembangan = PersetujuanPengembangan::whereNotIn('id_persetujuan_pengembangan', $nama_proyek_terpakai)->pluck('nama_proyek', 'id_persetujuan_pengembangan');

        return view('perencanaan_proyek.index',compact('trx_persetujuan_pengembangan'));
    }

    public function data()
    {
        $trx_perencanaan_proyek = PerencanaanProyek::leftJoin('trx_persetujuan_pengembangan', 'trx_persetujuan_pengembangan.id_persetujuan_pengembangan', '=', 'trx_perencanaan_proyek.id_persetujuan_pengembangan')
        ->select([
            'trx_perencanaan_proyek.id_perencanaan_proyek',
            'trx_perencanaan_proyek.id_persetujuan_pengembangan',
            'trx_perencanaan_proyek.nomor_proyek',
            'trx_perencanaan_proyek.pemilik_proyek',
            'trx_perencanaan_proyek.manajer_proyek',
            'trx_perencanaan_proyek.ruang_lingkup',
            'trx_perencanaan_proyek.tanggal_mulai',
            'trx_perencanaan_proyek.target_selesai',
            'trx_perencanaan_proyek.estimasi_biaya',
            'trx_perencanaan_proyek.nama_pemohon',
            'trx_perencanaan_proyek.jabatan_pemohon',
            'trx_perencanaan_proyek.tanggal_disiapkan',
            'trx_perencanaan_proyek.nama',
            'trx_perencanaan_proyek.is_approve',
            'trx_perencanaan_proyek.jabatan',
            'trx_perencanaan_proyek.tanggal_disetujui',
            'trx_perencanaan_proyek.file_pdf',  // Menggunakan alias untuk menghindari konflik
            'trx_perencanaan_proyek.created_at as proyek_created_at',
            'trx_perencanaan_proyek.updated_at as proyek_updated_at',
            'trx_perencanaan_proyek.progress',
            
            // Kolom dari tabel trx_persetujuan_pengembangan
            'trx_persetujuan_pengembangan.id_persetujuan_pengembangan as persetujuan_id',
            'trx_persetujuan_pengembangan.id_permintaan_pengembangan',
            'trx_persetujuan_pengembangan.id_mst_persetujuan',
            'trx_persetujuan_pengembangan.id_mst_persetujuanalasan',
            'trx_persetujuan_pengembangan.nama_proyek',
            'trx_persetujuan_pengembangan.deskripsi',
            'trx_persetujuan_pengembangan.namapemohon as persetujuan_namapemohon',
            'trx_persetujuan_pengembangan.namapeninjau',
            'trx_persetujuan_pengembangan.jabatanpeninjau',
            'trx_persetujuan_pengembangan.namapenyetuju',
            'trx_persetujuan_pengembangan.file_pdf as persetujuan_file_pdf',
            'trx_persetujuan_pengembangan.created_at as persetujuan_created_at',
            'trx_persetujuan_pengembangan.updated_at as persetujuan_updated_at',
        ])
        ->get();    

        return datatables()
            ->of($trx_perencanaan_proyek)
            ->addIndexColumn()
            ->addColumn('select_all', function ($trx_perencanaan_proyek) {
                return '
                    <input type="checkbox" name="id_perencanaan_proyek[]" value="'. $trx_perencanaan_proyek->id_perencanaan_proyek .'">
                ';
            })
            ->addColumn('deskripsi', function($trx_persetujuan_pengembangan){
                return $trx_persetujuan_pengembangan->deskripsi;
            })
            ->addColumn('aksi', function ($trx_perencanaan_proyek) {
                $id_proyek = $trx_perencanaan_proyek->id_perencanaan_proyek;
                // Cek apakah progress sudah 100% dan file PDF sudah terisi
                $isApproved = $trx_perencanaan_proyek->progress == 100 && !empty($trx_perencanaan_proyek->file_pdf);
                $alreadyApproved = (int) $trx_perencanaan_proyek->is_approve === 1; // Tambahkan kondisi untuk status approval
                // Ubah teks dan tombol berdasarkan kondisi approval
                $approveButton = $alreadyApproved
                    ? '<button type="button" class="btn btn-xs btn-success btn-flat" disabled><i class="fa fa-check"></i> Approved</button>' // Jika sudah di-approve
                    : ($isApproved 
                        ? '<button type="button" onclick="approveProyek(`'. route('perencanaan_proyek.approveProyek', $id_proyek) .'`)" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-check"></i> Approve</button>'
                        : ''); // Jika belum memenuhi syarat approval, tampilkan tombol Approve

                return '
                <div class="btn-group">
                    <button type="button" onclick="deleteData(`'. route('perencanaan_proyek.destroy', $id_proyek) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                    ' . (!$isApproved ? '
                    <button type="button" onclick="editForm(`'. route('perencanaan_proyek.update', $id_proyek) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button type="button" onclick="UploadPDF(`'. route('perencanaan_proyek.updatePDF', $id_proyek) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-upload"></i></button>
                    <button onclick="updateProgressForm(`'. route('perencanaan_proyek.editProgress', $id_proyek) .'`)" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-tasks"></i> Update Progress</button>
                    ' : '') . '
                    '. $approveButton .'
                    <button onclick="cetakDokumen(`'.route('perencanaan_proyek.cetakDokumen', $id_proyek) .'`)" class="btn btn-info btn-xs btn-flat">
                        <i class="fa fa-download"></i> Cetak Dokumen
                    </button>
                    <button type="button" onclick="viewForm(`'. route('perencanaan_proyek.view', $id_proyek) .'`)" class="btn btn btn-xs btn-primary btn-flat"><i class="fa fa-eye"></i></button>
                </div>
                ';
            })
            ->addColumn('file_pdf', function ($trx_perencanaan_proyek) {
                if ($trx_perencanaan_proyek->file_pdf) {
                    return '<a href="/storage/assets/pdf/' . $trx_perencanaan_proyek->file_pdf . '" target="_blank">Lihat PDF</a>';
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
        $sql_validasi = "   SELECT
                                flag_status.id_permintaan,
                                tpp.nomor_dokumen,
                                tpp.latar_belakang,
                                tpp.tujuan,
                                MAX( flag_status.flag ) AS max_flag 
                            FROM
                                flag_status
                                LEFT JOIN trx_permintaan_pengembangan AS tpp ON tpp.id_permintaan_pengembangan = flag_status.id_permintaan
                                LEFT JOIN trx_persetujuan_pengembangan AS tpp2 ON tpp2.id_permintaan_pengembangan = tpp.id_permintaan_pengembangan
                            WHERE
                                tpp2.id_persetujuan_pengembangan = $request->id_persetujuan_pengembangan AND tpp2.progress = 100 
                            GROUP BY
                                flag_status.id_permintaan,
                                tpp.nomor_dokumen,
                                tpp.latar_belakang,
                                tpp.tujuan 
                            HAVING
                                MAX( flag_status.flag ) = 2;
                        ";

        $result = DB::select($sql_validasi);

        if (count($result) > 0) {

            if ($request->hasFile('file_pdf')) {
                $file = $request->file('file_pdf');
                $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('assets/pdf', $filename, 'public');
                $data['file_pdf'] = $filename;
            }

            $trx_perencanaan_proyek = PerencanaanProyek::create($data);
            $lastId = $trx_perencanaan_proyek->id_perencanaan_proyek;
            $id_persetujuan_pengembangan = $trx_perencanaan_proyek->id_persetujuan_pengembangan;
            $id_permintaan_pengembangan  = DB::table('trx_perencanaan_proyek as tpp')
                                            ->join('trx_persetujuan_pengembangan as b', 'b.id_persetujuan_pengembangan', '=', 'tpp.id_persetujuan_pengembangan')
                                            ->where('tpp.id_persetujuan_pengembangan', $id_persetujuan_pengembangan)
                                            ->select('b.id_permintaan_pengembangan')
                                            ->first(); // Mengambil satu hasil 
                                            
            $id_permintaan_pengembangan = $id_permintaan_pengembangan->id_permintaan_pengembangan;

            FlagStatus::create([
                'kat_modul' => 3,
                'id_permintaan' => $id_permintaan_pengembangan,
                'nama_modul' => "Perencanaan Proyek",
                'id_tabel' => $lastId,
                'flag' => 3
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
    public function show($id_perencanaan_proyek)
    {
        $trx_perencanaan_proyek = PerencanaanProyek::find($id_perencanaan_proyek);

        return response()->json($trx_perencanaan_proyek);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_perencanaan_proyek)
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
    public function update(Request $request, $id_perencanaan_proyek)
    {
        $trx_perencanaan_proyek = PerencanaanProyek::find($id_perencanaan_proyek);
        $trx_perencanaan_proyek->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_perencanaan_proyek)
    {
        $trx_perencanaan_proyek = PerencanaanProyek::find($id_perencanaan_proyek);
        $trx_perencanaan_proyek->delete();

        return response(null, 204);
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->id_perencanaan_proyek;
        PerencanaanProyek::whereIn('id_perencanaan_proyek', $ids)->delete();
        return response()->json('Data berhasil dihapus', 200);
    }

    public function cetakDokumen(Request $request)
    {
        set_time_limit(300);

        // $ids = $request->id_perencanaan_proyek;
        $idPerencanaanProyek = $request->query();
        $id_perencanaan_proyek = key($idPerencanaanProyek); 
        $ids = (int) $id_perencanaan_proyek;

        $dataperencanaan = PerencanaanProyek::leftJoin('trx_persetujuan_pengembangan','trx_persetujuan_pengembangan.id_persetujuan_pengembangan', '=', 'trx_perencanaan_proyek.id_persetujuan_pengembangan')
            ->select('trx_persetujuan_pengembangan.nama_proyek', 'trx_persetujuan_pengembangan.deskripsi', 'trx_perencanaan_proyek.*')
            ->whereIn('trx_perencanaan_proyek.id_perencanaan_proyek', [$ids])
            ->get();

        $pdf = PDF::loadView('perencanaan_proyek.dokumen', compact('dataperencanaan'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('perencanaan.pdf');
    }

    public function view($id)
    {
        $trx_perencanaan_proyek = PerencanaanProyek::leftJoin('trx_persetujuan_pengembangan', 'trx_persetujuan_pengembangan.id_persetujuan_pengembangan', '=', 'trx_perencanaan_proyek.id_persetujuan_pengembangan')
        ->select(
            'trx_perencanaan_proyek.*',
            'trx_persetujuan_pengembangan.nama_proyek as nama_proyek',
            'trx_persetujuan_pengembangan.deskripsi as deskripsi',
        )
        ->findOrFail($id);

        return response()->json($trx_perencanaan_proyek);
    }
    public function updatePDF(Request $request, $id_perencanaan_proyek)
    {
        // Temukan data berdasarkan ID
        $trx_perencanaan_proyek = PerencanaanProyek::findOrFail($id_perencanaan_proyek);

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
            $trx_perencanaan_proyek->file_pdf = $filename;

            // Update data di database
            $trx_perencanaan_proyek->save();

            return response()->json('File PDF berhasil diperbarui', 200);
        }

        return response()->json('Tidak ada file yang diupload', 400);
    }

    // For Update Progress Project
    public function editProgress($id)
    {
            // Cari data permintaan pengembangan berdasarkan ID
            $trx_perencanaan_proyek = PerencanaanProyek::leftJoin('trx_persetujuan_pengembangan', 'trx_persetujuan_pengembangan.id_persetujuan_pengembangan', '=', 'trx_perencanaan_proyek.id_persetujuan_pengembangan')
            ->select([
                'trx_perencanaan_proyek.id_perencanaan_proyek',
                'trx_perencanaan_proyek.id_persetujuan_pengembangan',
                'trx_perencanaan_proyek.nomor_proyek',
                'trx_perencanaan_proyek.pemilik_proyek',
                'trx_perencanaan_proyek.manajer_proyek',
                'trx_perencanaan_proyek.ruang_lingkup',
                'trx_perencanaan_proyek.tanggal_mulai',
                'trx_perencanaan_proyek.target_selesai',
                'trx_perencanaan_proyek.estimasi_biaya',
                'trx_perencanaan_proyek.nama_pemohon',
                'trx_perencanaan_proyek.jabatan_pemohon',
                'trx_perencanaan_proyek.tanggal_disiapkan',
                'trx_perencanaan_proyek.nama',
                'trx_perencanaan_proyek.jabatan',
                'trx_perencanaan_proyek.tanggal_disetujui',
                'trx_perencanaan_proyek.file_pdf',  // Menggunakan alias untuk menghindari konflik
                'trx_perencanaan_proyek.progress',  // Menggunakan alias untuk menghindari konflik
                'trx_perencanaan_proyek.created_at as proyek_created_at',
                'trx_perencanaan_proyek.updated_at as proyek_updated_at',
                
                // Kolom dari tabel trx_persetujuan_pengembangan
                'trx_persetujuan_pengembangan.id_persetujuan_pengembangan as persetujuan_id',
                'trx_persetujuan_pengembangan.id_permintaan_pengembangan',
                'trx_persetujuan_pengembangan.id_mst_persetujuan',
                'trx_persetujuan_pengembangan.id_mst_persetujuanalasan',
                'trx_persetujuan_pengembangan.nama_proyek',
                'trx_persetujuan_pengembangan.deskripsi',
                'trx_persetujuan_pengembangan.namapemohon as persetujuan_namapemohon',
                'trx_persetujuan_pengembangan.namapeninjau',
                'trx_persetujuan_pengembangan.jabatanpeninjau',
                'trx_persetujuan_pengembangan.namapenyetuju',
                'trx_persetujuan_pengembangan.file_pdf as persetujuan_file_pdf',
                'trx_persetujuan_pengembangan.created_at as persetujuan_created_at',
                'trx_persetujuan_pengembangan.updated_at as persetujuan_updated_at',
            ])
            ->where('trx_perencanaan_proyek.id_perencanaan_proyek', $id)
            ->first();

        // Kirim data ke response JSON
        return response()->json($trx_perencanaan_proyek);
    }

    public function updateProgress(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'progress' => 'required|integer|min:0|max:100', // Validasi progress
            'nomor_proyek' => 'required|string|max:255', // Validasi nomor dokumen
        ]);

        // Cari data permintaan pengembangan berdasarkan ID
        $trx_perencanaan_proyek = PerencanaanProyek::findOrFail($id);

        // Update progress
        $trx_perencanaan_proyek->progress = $request->progress; // Pastikan ada kolom 'progress' di tabel
        $trx_perencanaan_proyek->save(); // Simpan perubahan

        // Kembali dengan respon sukses
        return redirect()->route('perencanaan_proyek.index');
    }

    // Method untuk melakukan approve proyek
    public function approveProyek($id)
    {
        // Ambil data proyek berdasarkan id
        $proyek = PerencanaanProyek::findOrFail($id);

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
