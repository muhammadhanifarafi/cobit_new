<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityAssuranceTesting extends Model
{
    use HasFactory;

    protected $table = 'trx_quality_assurance_testing';
    protected $primaryKey = 'id_quality_assurance_testing';
    protected $fillable = [
        'id_permintaan_pengembangan','nomor_proyek','nama_aplikasi','jenis_aplikasi', 'unit_pemilik','kebutuhan_nonfungsional','lokasi_pengujian','tgl_pengujian','manual_book',
        'nama_mengetahui','jabatan_mengetahui','tgl_diketahui','nama_penyetuju','jabatan_penyetuju','tgl_disetujui', 'file_pdf', 'progress'
    ];
}
