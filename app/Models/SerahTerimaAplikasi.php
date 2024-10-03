<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SerahTerimaAplikasi extends Model
{
    use HasFactory;

    protected $table = 'trx_serah_terima_aplikasi';
    protected $primaryKey = 'id_serah_terima_aplikasi';
    protected $fillable = [
        'id_permintaan_pengembangan', 'hari', 'tanggal', 'deskripsi', 'lokasi', 'nama_aplikasi', 'no_permintaan', 'keterangan', 'pemberi', 'penerima', 'nik_pemberi', 'nik_penerima', 'flag', 'progress', 'is_approve'
    ];
}