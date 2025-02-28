<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiMasuk extends Model
{
    use HasFactory;

    protected $table = 'transaksi_masuk';
    protected $fillable = ['tanggal', 'nama_barang', 'jumlah', 'satuan', 'penerima'];
}
