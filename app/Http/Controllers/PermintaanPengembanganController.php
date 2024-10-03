<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\PermintaanPengembangan;
use App\Models\FlagStatus;
use Barryvdh\DomPDF\Facade\Pdf;

class PermintaanPengembanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('permintaan_pengembangan.index');
    }

    public function data()
    {
        $trx_permintaan_pengembangan = PermintaanPengembangan::orderBy('id_permintaan_pengembangan', 'desc')->get();

        return datatables()
            ->of($trx_permintaan_pengembangan)
            ->addIndexColumn()
            ->addColumn('select_all', function ($trx_permintaan_pengembangan) {
                return '
                    <input type="checkbox" name="id_permintaan_pengembangan[]" value="'. $trx_permintaan_pengembangan->id_permintaan_pengembangan .'">
                ';
            })
            ->addColumn('aksi', function ($trx_permintaan_pengembangan) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`'. route('permintaan_pengembangan.update', $trx_permintaan_pengembangan->id_permintaan_pengembangan) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`'. route('permintaan_pengembangan.destroy', $trx_permintaan_pengembangan->id_permintaan_pengembangan) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                    <button onclick="updateProgressForm(`'. route('permintaan_pengembangan.editProgress', $trx_permintaan_pengembangan->id_permintaan_pengembangan) .'`)" class="btn btn-xs btn-warning btn-flat"><i class="fa fa-tasks"></i> Update Progress</button>
                    <button onclick="cetakDokumen(`'.route('permintaan_pengembangan.cetakDokumen', $trx_permintaan_pengembangan->id_permintaan_pengembangan) .'`)" class="btn btn-info btn-xs btn-flat">
                        <i class="fa fa-download"></i> Cetak Dokumen
                    </button>
                    <button onclick="UploadPDF(`'. route('permintaan_pengembangan.updatePDF', $trx_permintaan_pengembangan->id_permintaan_pengembangan) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fa fa-upload"></i></button>
                    <button onclick="viewForm(`'. route('permintaan_pengembangan.view', $trx_permintaan_pengembangan->id_permintaan_pengembangan) .'`)" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-eye"></i></button>
                </div>
                ';
            })
            ->addColumn('file_pdf', function ($trx_permintaan_pengembangan) {
                if ($trx_permintaan_pengembangan->file_pdf) {
                    return '<a href="/storage/assets/pdf/' . $trx_permintaan_pengembangan->file_pdf . '" target="_blank">Lihat PDF</a>';
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

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs('assets/lampiran', $filename, 'public');

            $data['lampiran'] = $filename;
        }

        if ($request->hasFile('file_pdf')) {
            $file = $request->file('file_pdf');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('assets/pdf', $filename, 'public');
            $data['file_pdf'] = $filename;
        }

        $trx_permintaan_pengembangan = PermintaanPengembangan::create($data);
        $lastId = $trx_permintaan_pengembangan->id_permintaan_pengembangan;

        FlagStatus::create([
            'kat_modul' => 1,
            'id_permintaan' => $lastId,
            'nama_modul' => "Permintaan Pengembangan",
            'id_tabel' => $lastId,
            'flag' => 1
        ]);

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trx_permintaan_pengembangan = PermintaanPengembangan::find($id);

        return response()->json($trx_permintaan_pengembangan);
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

    public function editProgress($id)
    {
        // Cari data permintaan pengembangan berdasarkan ID
        $permintaanPengembangan = PermintaanPengembangan::findOrFail($id);

        // Kirim data ke response JSON
        return response()->json($permintaanPengembangan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_permintaan_pengembangan)
    {
        $trx_permintaan_pengembangan = PermintaanPengembangan::findOrFail($id_permintaan_pengembangan);
        $data = $request->all();

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');

            $path = $file->storeAs('assets/lampiran', $file->getClientOriginalName(), 'public');

            $data['lampiran'] = 'storage/' . $path;
        }

        $trx_permintaan_pengembangan->update($data);
        return response()->json('Data berhasil diperbarui', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_permintaan_pengembangan)
    {
        $trx_permintaan_pengembangan = PermintaanPengembangan::find($id_permintaan_pengembangan);
        $trx_permintaan_pengembangan->delete();

        return response(null, 204);
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->id_permintaan_pengembangan;
        PermintaanPengembangan::whereIn('id_permintaan_pengembangan', $ids)->delete();
        return response()->json('Data berhasil dihapus', 200);
    }

    public function cetakDokumen(Request $request)
    {
        set_time_limit(300);

        $idPermintaan = $request->query();
        $id_permintaan_pengembangan = key($idPermintaan); 
        $id_permintaan_pengembangan = (int) $id_permintaan_pengembangan;
        
        $datapermintaan = PermintaanPengembangan::whereIn('id_permintaan_pengembangan', [$id_permintaan_pengembangan])->get();
        $no  = 1;

        $pdf = PDF::loadView('permintaan_pengembangan.dokumen', compact('datapermintaan', 'no'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('permintaan.pdf');
    }
    public function view($id)
    {
        $trx_permintaan_pengembangan = PermintaanPengembangan::findOrFail($id);
        return response()->json($trx_permintaan_pengembangan);
    }

    public function updatePDF(Request $request, $id_permintaan_pengembangan)
    {
        // Temukan data berdasarkan ID
        $trx_permintaan_pengembangan = PermintaanPengembangan::findOrFail($id_permintaan_pengembangan);

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
            $trx_permintaan_pengembangan->file_pdf = $filename;

            // Update data di database
            $trx_permintaan_pengembangan->save();

            return response()->json('File PDF berhasil diperbarui', 200);
        }

        return response()->json('Tidak ada file yang diupload', 400);
    }

    public function updateProgress(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'progress' => 'required|integer|min:0|max:100', // Validasi progress
            'nomor_dokumen' => 'required|string|max:255', // Validasi nomor dokumen
        ]);

        // Cari data permintaan pengembangan berdasarkan ID
        $permintaanPengembangan = PermintaanPengembangan::findOrFail($id);

        // Update progress
        $permintaanPengembangan->progress = $request->progress; // Pastikan ada kolom 'progress' di tabel
        $permintaanPengembangan->save(); // Simpan perubahan

        // Kembali dengan respon sukses
        return redirect()->route('permintaan_pengembangan.index');
    }
}
