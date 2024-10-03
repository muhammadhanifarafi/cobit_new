<?php

namespace App\Http\Controllers;

use App\Models\SerahTerimaAplikasi;
use Illuminate\Http\Request;
use App\Models\PermintaanPengembangan;
use Illuminate\Support\Facades\DB;
use App\Models\FlagStatus;
use Barryvdh\DomPDF\Facade\Pdf;

class SerahTerimaAplikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nama_permintaan_terpakai = SerahTerimaAplikasi::pluck('id_permintaan_pengembangan')->toArray();
        // $trx_permintaan_pengembangan = PermintaanPengembangan::whereNotIn('id_permintaan_pengembangan', $nama_permintaan_terpakai)->pluck('nomor_dokumen', 'id_permintaan_pengembangan');
        $trx_permintaan_pengembangan = PermintaanPengembangan::leftJoin('trx_persetujuan_pengembangan', 'trx_permintaan_pengembangan.id_permintaan_pengembangan', '=', 'trx_persetujuan_pengembangan.id_permintaan_pengembangan')
        ->whereNotIn('trx_permintaan_pengembangan.id_permintaan_pengembangan', $nama_permintaan_terpakai)
        ->whereIn('trx_permintaan_pengembangan.id_permintaan_pengembangan', function ($query) {
            $query->select('id_permintaan_pengembangan')
                ->from('trx_persetujuan_pengembangan');
        })
        ->pluck('trx_permintaan_pengembangan.nomor_dokumen', 'trx_permintaan_pengembangan.id_permintaan_pengembangan');
        
        return view('serah_terima_aplikasi.index', compact('trx_permintaan_pengembangan'));
    }

    public function data()
    {
        $trx_serah_terima_aplikasi = SerahTerimaAplikasi::join('trx_permintaan_pengembangan', 'trx_permintaan_pengembangan.id_permintaan_pengembangan', '=', 'trx_serah_terima_aplikasi.id_permintaan_pengembangan')
        ->orderBy('trx_serah_terima_aplikasi.id_serah_terima_aplikasi', 'desc')
        ->select('*')
        ->get();

        return datatables()
            ->of($trx_serah_terima_aplikasi)
            ->addIndexColumn()
            ->addColumn('select_all', function ($trx_serah_terima_aplikasi) {
                return '
                    <input type="checkbox" name="id_serah_terima_aplikasi[]" value="'. $trx_serah_terima_aplikasi->id_serah_terima_aplikasi .'">
                ';
            })
            ->addColumn('aksi', function ($trx_serah_terima_aplikasi) {
                // Cek apakah progress sudah 100% dan file PDF sudah terisi
                $isApproved = $trx_serah_terima_aplikasi->progress == 100;
                // && !empty($trx_serah_terima_aplikasi->file_pdf);
                $alreadyApproved = (int) $trx_serah_terima_aplikasi->is_approve === 1; // Tambahkan kondisi untuk status approval
                // Ubah teks dan tombol berdasarkan kondisi approval
                $approveButton = $alreadyApproved
                    ? '<button type="button" class="btn btn-xs btn-success btn-flat" disabled><i class="fa fa-check"></i> Approved</button>' // Jika sudah di-approve
                    : ($isApproved 
                        ? '<button type="button" onclick="approveProyek(`'. route('serah_terima_aplikasi.approveProyek', $trx_serah_terima_aplikasi->id_serah_terima_aplikasi) .'`)" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-check"></i> Approve</button>'
                        : ''); // Jika belum memenuhi syarat approval, tampilkan tombol Approve

                return '
                <div class="btn-group">
                    <button onclick="deleteData(`'. route('serah_terima_aplikasi.destroy', $trx_serah_terima_aplikasi->id_serah_terima_aplikasi) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                    ' . (!$isApproved ? '
                    <button onclick="editForm(`'. route('serah_terima_aplikasi.update', $trx_serah_terima_aplikasi->id_serah_terima_aplikasi) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="updateProgressForm(`'. route('serah_terima_aplikasi.editProgress', $trx_serah_terima_aplikasi->id_serah_terima_aplikasi) .'`)" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-tasks"></i> Update Progress</button>
                    ' : '') . '
                    '. $approveButton .'
                    <button onclick="viewForm(`'. route('serah_terima_aplikasi.view', $trx_serah_terima_aplikasi->id_serah_terima_aplikasi) .'`)" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-eye"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'select_all'])
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
        // $trx_serah_terima_aplikasi = SerahTerimaAplikasi::create($request->all());
        // $trx_serah_terima_aplikasi->save();
        // $trx_serah_terima_aplikasi = $trx_serah_terima_aplikasi->save();
       
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
                        LEFT JOIN trx_quality_assurance_testing AS tqat ON tqat.id_permintaan_pengembangan = tpp.id_permintaan_pengembangan
                        WHERE id_permintaan = $request->id_permintaan_pengembangan AND tqat.progress = 100 AND tqat.is_approve = 1
                        GROUP BY 
                            flag_status.id_permintaan, 
                            tpp.nomor_dokumen, 
                            tpp.latar_belakang, 
                            tpp.tujuan
                        HAVING 
                            MAX(flag_status.flag) = 7;
                        ";

        $result = DB::select($sql_validasi);

        if (count($result) > 0) {
            $trx_serah_terima_aplikasi = SerahTerimaAplikasi::create($data);
            $id_permintaan_pengembangan = $trx_serah_terima_aplikasi->id_permintaan_pengembangan;
            $lastId = $trx_serah_terima_aplikasi->id_serah_terima_aplikasi;

            FlagStatus::create([
                'kat_modul' => 8,
                'id_permintaan' => $id_permintaan_pengembangan,
                'nama_modul' => "Berita Acara Serah Terima",
                'id_tabel' => $lastId,
                'flag' => 8
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
    public function show($id_serah_terima_aplikasi)
    {
        $trx_serah_terima_aplikasi = SerahTerimaAplikasi::find($id_serah_terima_aplikasi);

        return response()->json($trx_serah_terima_aplikasi);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_serah_terima_aplikasi)
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
    public function update(Request $request, $id_serah_terima_aplikasi)
    {
        $trx_serah_terima_aplikasi = SerahTerimaAplikasi::find($id_serah_terima_aplikasi)->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_serah_terima_aplikasi)
    {
        $trx_serah_terima_aplikasi = SerahTerimaAplikasi::find($id_serah_terima_aplikasi);
        $trx_serah_terima_aplikasi->delete();

        return response(null, 204);
    }

    public function cetakDokumen(Request $request)
    {
        set_time_limit(300);

        $dataserahterima = SerahTerimaAplikasi::whereIn('id_serah_terima_aplikasi', $request->id_serah_terima_aplikasi)->get();
        $no  = 1;

        $pdf = PDF::loadView('serah_terima_aplikasi.dokumen', compact('dataserahterima', 'no'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('Berita Acara Serah Terima Aplikasi.pdf');
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->id_serah_terima_aplikasi;
        SerahTerimaAplikasi::whereIn('id_serah_terima_aplikasi', $ids)->delete();
        return response()->json('Data berhasil dihapus', 200);
    }

    public function view($id)
    {
        $trx_serah_terima_aplikasi = SerahTerimaAplikasi::findOrFail($id);
        return response()->json($trx_serah_terima_aplikasi);
    }

    // For Update Progress Project
    public function editProgress($id)
    {
        $trx_serah_terima_aplikasi = SerahTerimaAplikasi::join('trx_permintaan_pengembangan', 'trx_permintaan_pengembangan.id_permintaan_pengembangan', '=', 'trx_serah_terima_aplikasi.id_permintaan_pengembangan')
        ->select('trx_serah_terima_aplikasi.id_serah_terima_aplikasi', 'trx_serah_terima_aplikasi.id_permintaan_pengembangan', 'trx_permintaan_pengembangan.nomor_dokumen', 'trx_serah_terima_aplikasi.progress')
        ->where('trx_serah_terima_aplikasi.id_serah_terima_aplikasi', $id)
        ->first();

        // Kirim data ke response JSON
        return response()->json($trx_serah_terima_aplikasi);
    }

    public function updateProgress(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'progress' => 'required|integer|min:0|max:100', // Validasi progress
            'nomor_dokumen' => 'required|string|max:255', // Validasi nomor dokumen
        ]);

        // Cari data permintaan pengembangan berdasarkan ID
        $trx_serah_terima_aplikasi = SerahTerimaAplikasi::findOrFail($id);

        // Update progress
        $trx_serah_terima_aplikasi->progress = $request->progress; // Pastikan ada kolom 'progress' di tabel
        $trx_serah_terima_aplikasi->save(); // Simpan perubahan

        // Kembali dengan respon sukses
        return redirect()->route('serah_terima_aplikasi.index');
    }

    // Method untuk melakukan approve proyek
    public function approveProyek($id)
    {
        // Ambil data proyek berdasarkan id
        $proyek = SerahTerimaAplikasi::findOrFail($id);

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
