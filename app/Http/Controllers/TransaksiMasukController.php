<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\TransaksiMasuk;
use Illuminate\Http\Request;

class TransaksiMasukController extends Controller
{
    /**
     * Menampilkan daftar transaksi masuk dengan pagination.
     */
    public function index()
    {
        // Ambil data transaksi masuk dengan pagination (maksimal 10 data per halaman)
        $transaksi = TransaksiMasuk::paginate(10);

        // Kirim data ke view
        return view('transaksi.masuk.index', compact('transaksi'));
    }

    /**
     * Menampilkan form tambah transaksi masuk.
     */
    public function create()
    {
        // Ambil semua data barang dari database
        $barang = Barang::all();

        // Kirim data barang ke view
        return view('transaksi.masuk.create', compact('barang'));
    }

    /**
     * Menyimpan data transaksi masuk ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'barang_id' => 'required|exists:barang,id_barang', // Sesuaikan dengan primary key id_barang
            'jumlah' => 'required|integer|min:1',
            'penerima' => 'required|string|max:255',
        ]);

        // Cari barang berdasarkan ID
        $barang = Barang::findOrFail($request->barang_id);

        // Tambah stok barang
        $barang->update([
            'stok_barang' => $barang->stok_barang + $request->jumlah,
            'status' => $barang->stok_barang + $request->jumlah > 0 ? 'tersedia' : 'tidak tersedia',
        ]);

        // Simpan data transaksi masuk
        TransaksiMasuk::create([
            'tanggal' => $request->tanggal,
            'nama_barang' => $barang->nama_barang,
            'jumlah' => $request->jumlah,
            'satuan' => $barang->satuan,
            'penerima' => $request->penerima,
        ]);

        return redirect()->route('transaksi.masuk.index')->with('success', 'Transaksi masuk berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit transaksi masuk.
     */
    public function edit($id)
    {
        // Cari data transaksi masuk berdasarkan ID
        $transaksi = TransaksiMasuk::findOrFail($id);

        // Ambil semua data barang dari database
        $barang = Barang::all();

        // Kirim data transaksi dan barang ke view
        return view('transaksi.masuk.edit', compact('transaksi', 'barang'));
    }

    /**
     * Memperbarui data transaksi masuk di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'barang_id' => 'required|exists:barang,id_barang', // Sesuaikan dengan primary key id_barang
            'jumlah' => 'required|integer|min:1',
            'penerima' => 'required|string|max:255',
        ]);

        // Cari barang berdasarkan ID
        $barang = Barang::findOrFail($request->barang_id);

        // Ambil data transaksi lama
        $transaksi = TransaksiMasuk::findOrFail($id);
        $jumlahLama = $transaksi->jumlah;

        // Update stok barang (kurangi jumlah lama, tambah jumlah baru)
        $barang->update([
            'stok_barang' => $barang->stok_barang - $jumlahLama + $request->jumlah,
            'status' => $barang->stok_barang - $jumlahLama + $request->jumlah > 0 ? 'tersedia' : 'tidak tersedia',
        ]);

        // Update data transaksi masuk
        $transaksi->update([
            'tanggal' => $request->tanggal,
            'nama_barang' => $barang->nama_barang,
            'jumlah' => $request->jumlah,
            'satuan' => $barang->satuan,
            'penerima' => $request->penerima,
        ]);

        return redirect()->route('transaksi.masuk.index')->with('success', 'Transaksi masuk berhasil diperbarui.');
    }

    /**
     * Menghapus data transaksi masuk dari database.
     */
    public function destroy($id)
    {
        // Ambil data transaksi
        $transaksi = TransaksiMasuk::findOrFail($id);

        // Cari barang terkait
        $barang = Barang::where('nama_barang', $transaksi->nama_barang)->first();

        if ($barang) {
            // Kurangi stok barang sesuai jumlah transaksi
            $barang->update([
                'stok_barang' => $barang->stok_barang - $transaksi->jumlah,
                'status' => $barang->stok_barang - $transaksi->jumlah > 0 ? 'tersedia' : 'tidak tersedia',
            ]);
        }

        // Hapus transaksi
        $transaksi->delete();

        return redirect()->route('transaksi.masuk.index')->with('success', 'Transaksi masuk berhasil dihapus.');
    }
}
