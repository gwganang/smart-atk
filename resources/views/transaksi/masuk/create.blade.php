@extends('layouts.app')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Tambah Transaksi Masuk</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('transaksi.masuk.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="barang_id" class="form-label">Nama Barang</label>
                    <select name="barang_id" id="barang_id" class="form-control" required>
                        <option value="">-- Pilih Barang --</option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->id_barang }}">{{ $item->nama_barang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="satuan" class="form-label">Satuan</label>
                    <input type="text" name="satuan" id="satuan" class="form-control" readonly>
                </div>
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="penerima" class="form-label">Penerima</label>
                    <input type="text" name="penerima" id="penerima" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-custom">Simpan</button>
            </form>
        </div>
    </div>

    <script>
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
    </script>
@endsection
