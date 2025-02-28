@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Daftar Barang</h4>
        </div>
        <div class="card-body">
            <a href="{{ route('barang.create') }}" class="btn btn-light mb-3"><i class="fas fa-plus"></i> Tambah Barang</a>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama Barang</th>
                            <th>Stok Barang</th>
                            <th>Satuan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($barang as $item)
                            <tr>
                                <td>{{ $loop->iteration + $barang->firstItem() - 1 }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->stok_barang }}</td>
                                <td>{{ $item->satuan }}</td>
                                <td>{{ $item->status }}</td>
                                <td>
                                    <a href="{{ route('barang.edit', $item->id_barang) }}"
                                        class="btn btn-sm btn-warning me-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('barang.destroy', $item->id_barang) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data barang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex flex-column align-items-center">
                {{ $barang->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
@endsection
