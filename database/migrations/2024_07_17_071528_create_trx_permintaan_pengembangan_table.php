<?php

use App\Models\PermintaanPengembangan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatetrxPermintaanPengembanganTable extends Migration
{
    public function up()
    {
        Schema::create('trx_permintaan_pengembangan', function (Blueprint $table) {
            $table->id();
            $table->text('latar_belakang');
            $table->text('tujuan');
            $table->text('target_implementasi_sistem');
            $table->text('fungsi_sistem_informasi');
            $table->text('jenis_aplikasi');
            $table->text('pengguna');
            $table->text('uraian_permintaan_tambahan');
            $table->string('lampiran')->nullable();
            $table->text('nama_pemohon');
            $table->text('jabatan_pemohon');
            $table->date('tanggal_disiapkan');
            $table->text('nama');
            $table->text('jabatan');
            $table->date('tanggal_disetujui');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trx_permintaan_pengembangan');
    }

        
}
