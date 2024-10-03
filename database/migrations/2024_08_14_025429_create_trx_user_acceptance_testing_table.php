<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxUserAcceptanceTestingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_user_acceptance_testing', function (Blueprint $table) {
            $table->id('id_user_acceptance_testing');
            $table->text('nomor_proyek');
            $table->text('nama_aplikasi');
            $table->text('jenis_aplikasi');
            $table->text('kebutuhan_fungsional');
            $table->text('kebutuhan_nonfungsional');
            $table->text('unit_pemilik_proses_bisnis');
            $table->text('lokasi_pengujian');
            $table->date('tgl_pengujian');
            $table->text('manual_book');
            $table->text('nama_penyusun');
            $table->text('jabatan_penyusun');
            $table->date('tgl_disusun');
            $table->text('nama_penyetuju');
            $table->text('jabatan_penyetuju');
            $table->date('tanggal_disetujui');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_user_acceptance_testing');
    }
}
