<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang'; // Nama tabel
    protected $primaryKey = 'id_barang'; // Primary key kustom
    public $incrementing = true; // Pastikan primary key bersifat auto-increment
    protected $keyType = 'int'; // Tipe data primary key (integer)
    protected $fillable = ['nama_barang', 'stok_barang', 'satuan', 'status'];
}
