<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxAnalisisDesainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_analisis_desain', function (Blueprint $table) {
            $table->id();
            $table->string('Nama_Proyek');
            $table->string('Deskripsi_Proyek');
            $table->string('ManajerProyek');
            $table->string('Kebutuhan_Fungsi');
            $table->string('gambaran_arsitektur');
            $table->string('detil_arsitektur');
            $table->string('lampiran_mockup');
            $table->string('nama_pemohon');
            $table->string('jabatan_pemohon');
            $table->date('Tanggal_disiapkan');
            $table->string('nama');
            $table->string('jabatan');
            $table->date('tanggal_disetujui');
            $table->string ('status');
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
        Schema::dropIfExists('trx_analisis_desain');
    }
}
