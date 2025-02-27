<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Menampilkan daftar barang.
     */
    public function index()
    {
        $barang = Barang::all();
        return view('barang.index', compact('barang'));
    }

    /**
     * Menampilkan form tambah barang.
     */
    public function create()
    {
        return view('barang.create');
    }

    /**
     * Menyimpan data barang baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok_barang' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
        ]);

        $status = $request->stok_barang > 0 ? 'tersedia' : 'tidak tersedia';

        Barang::create([
            'nama_barang' => $request->nama_barang,
            'stok_barang' => $request->stok_barang,
            'satuan' => $request->satuan,
            'status' => $status,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit barang.
     */
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    /**
     * Memperbarui data barang di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok_barang' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
        ]);

        $barang = Barang::findOrFail($id);
        $status = $request->stok_barang > 0 ? 'tersedia' : 'tidak tersedia';

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'stok_barang' => $request->stok_barang,
            'satuan' => $request->satuan,
            'status' => $status,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Menghapus data barang dari database.
     */
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }

    public function getSatuan($id)
    {
        $barang = \App\Models\Barang::findOrFail($id);
        return response()->json(['satuan' => $barang->satuan]);
    }
}
