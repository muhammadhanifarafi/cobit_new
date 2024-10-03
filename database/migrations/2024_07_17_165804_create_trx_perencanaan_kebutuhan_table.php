<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxPerencanaanKebutuhanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_perencanaan_kebutuhan', function (Blueprint $table) {
            $table->id();
            $table->text('nama_proyek');
            $table->text('deskripsi');
            $table->text('pemilik_proyek');
            $table->text('manajer_proyek');
            $table->text('stakeholders');
            $table->text('kebutuhan_fungsional');
            $table->text('kebutuhan_nonfungsional');
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trx_perencanaan_kebutuhan');
    }
}
