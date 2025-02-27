@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">Edit Barang</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('barang.update', $barang->id_barang) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" class="form-control"
                        value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                </div>
                <div class="mb-3">
                    <label for="stok_barang" class="form-label">Stok Barang</label>
                    <input type="number" name="stok_barang" id="stok_barang" class="form-control"
                        value="{{ old('stok_barang', $barang->stok_barang) }}" required>
                </div>
                <div class="mb-3">
                    <label for="satuan" class="form-label">Satuan</label>
                    <input type="text" name="satuan" id="satuan" class="form-control"
                        value="{{ old('satuan', $barang->satuan) }}" required>
                </div>
                <button type="submit" class="btn btn-custom">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection
