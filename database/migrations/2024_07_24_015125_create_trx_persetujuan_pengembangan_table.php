<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrxpersetujuanpengembanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trx_persetujuan_pengembangan', function (Blueprint $table) {
            $table->id();
            $table->text('nomor_proyek');
            $table->text('nama_proyek');
            $table->text('deskripsi');
            $table->text('status_persetujuan');
            $table->text('alasan_persetujuan');
            $table->text('namapemohon');
            $table->text('namapeninjau');
            $table->text('jabatanpeninjau');
            $table->text('namapenyetuju');
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
        Schema::dropIfExists('trx_perencanaan_proyek');
    }
}
