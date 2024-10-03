<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\UserAcceptanceTesting;
use App\Models\PermintaanPengembangan;
use Illuminate\Support\Facades\DB;
use App\Models\FlagStatus;
use Barryvdh\DomPDF\Facade\Pdf;

class UserAcceptanceTestingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nama_permintaan_terpakai = UserAcceptanceTesting::pluck('id_permintaan_pengembangan')->toArray();
        // $trx_permintaan_pengembangan = PermintaanPengembangan::whereNotIn('id_permintaan_pengembangan', $nama_permintaan_terpakai)->pluck('nomor_dokumen', 'id_permintaan_pengembangan');
        $trx_permintaan_pengembangan = PermintaanPengembangan::leftJoin('trx_persetujuan_pengembangan', 'trx_permintaan_pengembangan.id_permintaan_pengembangan', '=', 'trx_persetujuan_pengembangan.id_permintaan_pengembangan')
        ->whereNotIn('trx_permintaan_pengembangan.id_permintaan_pengembangan', $nama_permintaan_terpakai)
        ->whereIn('trx_permintaan_pengembangan.id_permintaan_pengembangan', function ($query) {
            $query->select('id_permintaan_pengembangan')
                ->from('trx_persetujuan_pengembangan');
        })
        ->pluck('trx_permintaan_pengembangan.nomor_dokumen', 'trx_permintaan_pengembangan.id_permintaan_pengembangan');

        return view('user_acceptance_testing.index', compact('trx_permintaan_pengembangan'));
    }

    public function data()
    {
        $trx_user_acceptance_testing = UserAcceptanceTesting::orderBy('id_user_acceptance_testing', 'desc')->get();

        return datatables()
            ->of($trx_user_acceptance_testing)
            ->addIndexColumn()
            ->addColumn('select_all', function ($trx_user_acceptance_testing) {
                return '
                    <input type="checkbox" name="id_user_acceptance_testing[]" value="'. $trx_user_acceptance_testing->id_user_acceptance_testing .'">
                ';
            })
            ->addColumn('aksi', function ($trx_user_acceptance_testing) {
                // Cek apakah progress sudah 100% dan file PDF sudah terisi
                $isApproved = $trx_user_acceptance_testing->progress == 100;
                // && !empty($trx_user_acceptance_testing->file_pdf);
                $alreadyApproved = (int) $trx_user_acceptance_testing->is_approve === 1; // Tambahkan kondisi untuk status approval
                // Ubah teks dan tombol berdasarkan kondisi approval
                $approveButton = $alreadyApproved
                    ? '<button type="button" class="btn btn-xs btn-success btn-flat" disabled><i class="fa fa-check"></i> Approved</button>' // Jika sudah di-approve
                    : ($isApproved 
                        ? '<button type="button" onclick="approveProyek(`'. route('user_acceptance_testing.approveProyek', $trx_user_acceptance_testing->id_user_acceptance_testing) .'`)" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-check"></i> Approve</button>'
                        : ''); // Jika belum memenuhi syarat approval, tampilkan tombol Approve

                return '
                <div class="btn-group">
                    ' . (!$isApproved ? '
                    <button onclick="editForm(`'. route('user_acceptance_testing.update', $trx_user_acceptance_testing->id_user_acceptance_testing) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="updateProgressForm(`'. route('user_acceptance_testing.editProgress', $trx_user_acceptance_testing->id_user_acceptance_testing) .'`)" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-tasks"></i> Update Progress</button>
                    ' : '') . '
                    '. $approveButton .'
                    <button onclick="deleteData(`'. route('user_acceptance_testing.destroy', $trx_user_acceptance_testing->id_user_acceptance_testing) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
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
        // $trx_user_acceptance_testing = UserAcceptanceTesting::create($request->all());
        // $trx_user_acceptance_testing->save();
        // $end_trx_user_acceptance_testing = $trx_user_acceptance_testing->save();
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
                        LEFT JOIN trx_analisis_desain AS tad ON tad.id_permintaan_pengembangan = tpp.id_permintaan_pengembangan
                        WHERE id_permintaan = $request->id_permintaan_pengembangan AND tad.progress = 100 AND tad.is_approve = 1 
                        GROUP BY 
                            flag_status.id_permintaan, 
                            tpp.nomor_dokumen, 
                            tpp.latar_belakang, 
                            tpp.tujuan
                        HAVING 
                            MAX(flag_status.flag) = 5;
                        ";

        $result = DB::select($sql_validasi);

        if (count($result) > 0) {
            $trx_user_acceptance_testing = UserAcceptanceTesting::create($data);
            $id_permintaan_pengembangan = $trx_user_acceptance_testing->id_permintaan_pengembangan;
            $lastId = $trx_user_acceptance_testing->id_user_acceptance_testing;

            FlagStatus::create([
                'kat_modul' => 6,
                'id_permintaan' => $id_permintaan_pengembangan,
                'nama_modul' => "User Acceptance Testing",
                'id_tabel' => $lastId,
                'flag' => 6
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
        $trx_user_acceptance_testing = UserAcceptanceTesting::find($id);

        return response()->json($trx_user_acceptance_testing);
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
    public function update(Request $request, $id_user_acceptance_testing)
    {
        $trx_user_acceptance_testing = UserAcceptanceTesting::find($id_user_acceptance_testing);
        $trx_user_acceptance_testing->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_user_acceptance_testing)
    {
        $trx_user_acceptance_testing = UserAcceptanceTesting::find($id_user_acceptance_testing);
        $trx_user_acceptance_testing->delete();

        return response(null, 204);
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->id_user_acceptance_testing;
        UserAcceptanceTesting::whereIn('id_user_acceptance_testing', $ids)->delete();
        return response()->json('Data berhasil dihapus', 200);
    }

    public function cetakDokumen(Request $request)
    {
        set_time_limit(300);

        $dataUserAcceptanceTesting = UserAcceptanceTesting::whereIn('id_user_acceptance_testing', $request->id_user_acceptance_testing)->get();
        $no  = 1;

        $pdf = PDF::loadView('user_acceptance_testing.dokumen', compact('dataUserAcceptanceTesting', 'no'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('User Acceptance Testing (UAT).pdf');
    }
    public function cetakDokumenPerencanaan(Request $request)
    {
        set_time_limit(300);

        $dataUserAcceptanceTesting = UserAcceptanceTesting::whereIn('id_user_acceptance_testing', $request->id_user_acceptance_testing)->get();
        $no  = 1;

        $pdf = PDF::loadView('user_acceptance_testing.dokumenperencanaan', compact('dataUserAcceptanceTesting', 'no'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('Perencanaan User Acceptance Testing (UAT).pdf');
    }

    // For Update Progress Project
    public function editProgress($id)
    {
        $trx_user_acceptance_testing = UserAcceptanceTesting::leftJoin('trx_permintaan_pengembangan', 'trx_permintaan_pengembangan.id_permintaan_pengembangan', '=', 'trx_user_acceptance_testing.id_permintaan_pengembangan')
            ->select(
                'trx_user_acceptance_testing.id_permintaan_pengembangan', 
                'trx_permintaan_pengembangan.nomor_dokumen', 
                'trx_user_acceptance_testing.progress',
            )
            ->where('trx_user_acceptance_testing.id_user_acceptance_testing', $id)
            ->first();

        // Kirim data ke response JSON
        return response()->json($trx_user_acceptance_testing);
    }

    public function updateProgress(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'progress' => 'required|integer|min:0|max:100', // Validasi progress
            'nomor_dokumen' => 'required|string|max:255', // Validasi nomor dokumen
        ]);

        // Cari data permintaan pengembangan berdasarkan ID
        $trx_user_acceptance_testing = UserAcceptanceTesting::findOrFail($id);

        // Update progress
        $trx_user_acceptance_testing->progress = $request->progress; // Pastikan ada kolom 'progress' di tabel
        $trx_user_acceptance_testing->save(); // Simpan perubahan

        // Kembali dengan respon sukses
        return redirect()->route('user_acceptance_testing.index');
    }

    // Method untuk melakukan approve proyek
    public function approveProyek($id)
    {
        // Ambil data proyek berdasarkan id
        $proyek = UserAcceptanceTesting::findOrFail($id);

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
