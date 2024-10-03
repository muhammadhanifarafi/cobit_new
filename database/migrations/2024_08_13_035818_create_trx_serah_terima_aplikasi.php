<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxserahterimaaplikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_serah_terima_aplikasi', function (Blueprint $table) {
            $table->id();
            $table->text('hari');
            $table->text('tanggal');
            $table->text('deskripsi');
            $table->text('lokasi');
            $table->text('nama_aplikasi');
            $table->text('no_permintaan');
            $table->text('keterangan');
            $table->text('pemberi');
            $table->text('penerima');
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
        Schema::dropIfExists('trx_serah_terima_aplikasi');
    }
}
