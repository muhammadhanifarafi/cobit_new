<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAcceptanceTesting extends Model
{
    use HasFactory;

    protected $table = 'trx_user_acceptance_testing';
    protected $primaryKey = 'id_user_acceptance_testing';
    protected $fillable = [
        'id_permintaan_pengembangan','nomor_proyek','nama_aplikasi','jenis_aplikasi','kebutuhan_fungsional', 'kebutuhan_nonfungsional','unit_pemilik_proses_bisnis','lokasi_pengujian','tgl_pengujian','manual_book',
        'nama_penyusun','jabatan_penyusun','tgl_disusun','nama_penyetuju','jabatan_penyetuju','tanggal_disetujui'
    ];
}
