<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\TransaksiMasuk;
use App\Models\TransaksiKeluar;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik dasar
        $totalBarang = Barang::count();
        $totalTransaksiMasuk = TransaksiMasuk::count();
        $totalTransaksiKeluar = TransaksiKeluar::count();

        // Barang dengan stok terendah (5 barang)
        $barangStokTerendah = Barang::orderBy('stok_barang', 'asc')->limit(5)->get();

        // Total stok barang keseluruhan
        $totalStokBarang = Barang::sum('stok_barang');

        // Data untuk grafik
        $dataGrafik = [
            'barang' => $totalBarang,
            'transaksi_masuk' => $totalTransaksiMasuk,
            'transaksi_keluar' => $totalTransaksiKeluar,
        ];

        return view('dashboard.index', compact(
            'totalBarang',
            'totalTransaksiMasuk',
            'totalTransaksiKeluar',
            'barangStokTerendah',
            'totalStokBarang',
            'dataGrafik'
        ));
    }
}
