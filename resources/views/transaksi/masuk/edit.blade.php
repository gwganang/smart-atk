@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">Edit Transaksi Masuk</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('transaksi.masuk.update', $transaksi->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control"
                        value="{{ old('tanggal', $transaksi->tanggal) }}" required>
                </div>
                <div class="mb-3">
                    <label for="barang_id" class="form-label">Nama Barang</label>
                    <select name="barang_id" id="barang_id" class="form-control" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->id_barang }}"
                                {{ $transaksi->nama_barang == $item->nama_barang ? 'selected' : '' }}>
                                {{ $item->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="satuan" class="form-label">Satuan</label>
                    <input type="text" name="satuan" id="satuan" class="form-control"
                        value="{{ old('satuan', $transaksi->satuan) }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control"
                        value="{{ old('jumlah', $transaksi->jumlah) }}" required>
                </div>
                <div class="mb-3">
                    <label for="penerima" class="form-label">Penerima</label>
                    <input type="text" name="penerima" id="penerima" class="form-control"
                        value="{{ old('penerima', $transaksi->penerima) }}" required>
                </div>
                <button type="submit" class="btn btn-custom">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <script>
        // Ambil satuan saat dropdown barang diubah
        document.getElementById('barang_id').addEventListener('change', function() {
            const barangId = this.value;
            const satuanInput = document.getElementById('satuan');

            if (barangId) {
                fetch(`/api/barang/${barangId}`)
                    .then(response => response.json())
                    .then(data => {
                        satuanInput.value = data.satuan; // Auto-fill satuan
                    })
                    .catch(error => {
                        console.error('Error fetching satuan:', error);
                    });
            } else {
                satuanInput.value = '';
            }
        });

        // Set satuan awal saat halaman dimuat
        window.addEventListener('DOMContentLoaded', function() {
            const barangId = document.getElementById('barang_id').value;
            const satuanInput = document.getElementById('satuan');

            if (barangId) {
                fetch(`/api/barang/${barangId}`)
                    .then(response => response.json())
                    .then(data => {
                        satuanInput.value = data.satuan; // Auto-fill satuan
                    })
                    .catch(error => {
                        console.error('Error fetching satuan:', error);
                    });
            }
        });
    </script>
@endsection
