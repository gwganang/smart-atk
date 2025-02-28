@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Daftar Transaksi Keluar</h4>
        </div>
        <div class="card-body">
            <a href="{{ route('transaksi.keluar.create') }}" class="btn btn-light mb-3"><i class="fas fa-plus"></i> Tambah
                Transaksi Keluar</a>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Pemohon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksi as $item)
                            <tr>
                                <td>{{ $loop->iteration + $transaksi->firstItem() - 1 }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ $item->satuan }}</td>
                                <td>{{ $item->pemohon }}</td>
                                <td>
                                    <a href="{{ route('transaksi.keluar.edit', $item->id) }}"
                                        class="btn btn-sm btn-warning me-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('transaksi.keluar.destroy', $item->id) }}" method="POST"
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
                                <td colspan="7" class="text-center">Tidak ada data transaksi keluar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $transaksi->links('vendor.pagination.custom') }}
            </div>
        </div>
    </div>
@endsection
