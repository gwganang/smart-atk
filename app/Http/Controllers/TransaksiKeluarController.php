<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\TransaksiKeluar;
use Illuminate\Http\Request;

class TransaksiKeluarController extends Controller
{
    /**
     * Menampilkan daftar transaksi keluar dengan pagination.
     */
    public function index()
    {
        // Ambil data transaksi keluar dengan pagination (maksimal 10 data per halaman)
        $transaksi = TransaksiKeluar::paginate(10);

        // Kirim data ke view
        return view('transaksi.keluar.index', compact('transaksi'));
    }

    /**
     * Menampilkan form tambah transaksi keluar.
     */
    public function create()
    {
        // Ambil semua data barang dari database
        $barang = Barang::all();

        // Kirim data barang ke view
        return view('transaksi.keluar.create', compact('barang'));
    }

    /**
     * Menyimpan data transaksi keluar ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'barang_id' => 'required|exists:barang,id_barang', // Sesuaikan dengan primary key id_barang
            'jumlah' => 'required|integer|min:1',
            'pemohon' => 'required|string|max:255',
        ]);

        // Cari barang berdasarkan ID
        $barang = Barang::findOrFail($request->barang_id);

        // Validasi stok barang
        if ($barang->stok_barang < $request->jumlah) {
            return redirect()->back()->withErrors(['jumlah' => 'Stok barang tidak mencukupi.']);
        }

        // Kurangi stok barang
        $barang->update([
            'stok_barang' => $barang->stok_barang - $request->jumlah,
            'status' => $barang->stok_barang - $request->jumlah > 0 ? 'tersedia' : 'tidak tersedia',
        ]);

        // Simpan data transaksi keluar
        TransaksiKeluar::create([
            'tanggal' => $request->tanggal,
            'nama_barang' => $barang->nama_barang,
            'jumlah' => $request->jumlah,
            'satuan' => $barang->satuan,
            'pemohon' => $request->pemohon,
        ]);

        return redirect()->route('transaksi.keluar.index')->with('success', 'Transaksi keluar berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit transaksi keluar.
     */
    public function edit($id)
    {
        // Cari data transaksi keluar berdasarkan ID
        $transaksi = TransaksiKeluar::findOrFail($id);

        // Ambil semua data barang dari database
        $barang = Barang::all();

        // Kirim data transaksi dan barang ke view
        return view('transaksi.keluar.edit', compact('transaksi', 'barang'));
    }

    /**
     * Memperbarui data transaksi keluar di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'barang_id' => 'required|exists:barang,id_barang', // Sesuaikan dengan primary key id_barang
            'jumlah' => 'required|integer|min:1',
            'pemohon' => 'required|string|max:255',
        ]);

        // Cari barang berdasarkan ID
        $barang = Barang::findOrFail($request->barang_id);

        // Ambil data transaksi lama
        $transaksi = TransaksiKeluar::findOrFail($id);
        $jumlahLama = $transaksi->jumlah;

        // Validasi stok barang setelah update
        if ($barang->stok_barang + $jumlahLama < $request->jumlah) {
            return redirect()->back()->withErrors(['jumlah' => 'Stok barang tidak mencukupi.']);
        }

        // Update stok barang (tambah jumlah lama, kurangi jumlah baru)
        $barang->update([
            'stok_barang' => $barang->stok_barang + $jumlahLama - $request->jumlah,
            'status' => $barang->stok_barang + $jumlahLama - $request->jumlah > 0 ? 'tersedia' : 'tidak tersedia',
        ]);

        // Update data transaksi keluar
        $transaksi->update([
            'tanggal' => $request->tanggal,
            'nama_barang' => $barang->nama_barang,
            'jumlah' => $request->jumlah,
            'satuan' => $barang->satuan,
            'pemohon' => $request->pemohon,
        ]);

        return redirect()->route('transaksi.keluar.index')->with('success', 'Transaksi keluar berhasil diperbarui.');
    }

    /**
     * Menghapus data transaksi keluar dari database.
     */
    public function destroy($id)
    {
        // Ambil data transaksi
        $transaksi = TransaksiKeluar::findOrFail($id);

        // Cari barang terkait
        $barang = Barang::where('nama_barang', $transaksi->nama_barang)->first();

        if ($barang) {
            // Tambah stok barang sesuai jumlah transaksi
            $barang->update([
                'stok_barang' => $barang->stok_barang + $transaksi->jumlah,
                'status' => $barang->stok_barang + $transaksi->jumlah > 0 ? 'tersedia' : 'tidak tersedia',
            ]);
        }

        // Hapus transaksi
        $transaksi->delete();

        return redirect()->route('transaksi.keluar.index')->with('success', 'Transaksi keluar berhasil dihapus.');
    }
}
