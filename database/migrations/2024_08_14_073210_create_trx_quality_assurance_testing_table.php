<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxQualityAssuranceTestingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_quality_assurance_testing', function (Blueprint $table) {
            $table->id('id_qat');
            $table->text('nomor_proyek');
            $table->text('nama_aplikasi');
            $table->text('jenis_aplikasi');
            $table->text('unit_pemilik');
            $table->text('kebutuhan_nonfungsional');
            $table->text('lokasi_pengujian');
            $table->date('tgl_pengujian');
            $table->text('manual_book');
            $table->text('nama_mengetahui');
            $table->text('jabatan_mengetahui');
            $table->date('tgl_diketahui');
            $table->text('nama_penyetuju');
            $table->text('jabatan_penyetuju');
            $table->date('tgl_disetujui');
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
        Schema::dropIfExists('trx_quality_assurance_testing');
    }
}
