<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\BarangController;

Route::resource('barang', BarangController::class);
Route::get('/api/barang/{id}', [BarangController::class, 'getSatuan']);


use App\Http\Controllers\TransaksiMasukController;
use App\Http\Controllers\TransaksiKeluarController;

Route::prefix('transaksi')->group(function () {
    Route::resource('masuk', TransaksiMasukController::class)->names('transaksi.masuk');
    Route::resource('keluar', TransaksiKeluarController::class)->names('transaksi.keluar');
});
