<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transaksi_keluar', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama_barang');
            $table->integer('jumlah');
            $table->string('satuan');
            $table->string('pemohon');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi_keluar');
    }
};
