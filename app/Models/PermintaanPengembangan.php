<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanPengembangan extends Model
{
    use HasFactory;

    protected $table = 'trx_permintaan_pengembangan';
    protected $primaryKey = 'id_permintaan_pengembangan';
    protected $fillable = [
        'nomor_dokumen','latar_belakang','tujuan','target_implementasi_sistem','fungsi_sistem_informasi','jenis_aplikasi','pengguna','uraian_permintaan_tambahan',
        'lampiran','nama_pemohon','jabatan_pemohon','tanggal_disiapkan','nama','jabatan','tanggal_disetujui', 'file_pdf', 'progress', 'pic', 'is_approve'
    ];
}
