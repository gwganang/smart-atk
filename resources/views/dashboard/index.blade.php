@extends('layouts.app')

@section('content')
    <div class="row">
        <style>
            /* Responsive Widgets */
            @media (max-width: 768px) {
                .col-md-3 {
                    flex: 0 0 50%;
                    /* 2 widget per baris di mobile */
                    max-width: 50%;
                }

                .card-body .display-4 {
                    font-size: 2rem;
                    /* Ukuran font lebih kecil di mobile */
                }
            }
        </style>

        <!-- Widget Statistik -->
        <div class="row">
            <div class="col-md-3">
                <div class="card bg-primary text-white shadow-sm fade-in">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-box me-2"></i>Total Barang</h5>
                        <p class="card-text display-4">{{ $totalBarang }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white shadow-sm fade-in">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-arrow-circle-down me-2"></i>Transaksi Masuk</h5>
                        <p class="card-text display-4">{{ $totalTransaksiMasuk }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white shadow-sm fade-in">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-arrow-circle-up me-2"></i>Transaksi Keluar</h5>
                        <p class="card-text display-4">{{ $totalTransaksiKeluar }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-secondary text-white shadow-sm fade-in">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-layer-group me-2"></i>Total Stok Barang</h5>
                        <p class="card-text display-4">{{ $totalStokBarang }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Responsive Table */
        @media (max-width: 768px) {

            .table th:nth-child(4),
            .table td:nth-child(4) {
                display: none;
                /* Sembunyikan kolom "Satuan" di mobile */
            }
        }
    </style>

    <!-- Barang dengan Stok Terendah -->
    <div class="mt-4 fade-in">
        <h4>Barang dengan Stok Terendah</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Nama Barang</th>
                        <th>Stok Barang</th>
                        <th>Satuan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($barangStokTerendah as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->stok_barang }}</td>
                            <td>{{ $item->satuan }}</td>
                            <td>
                                @if ($item->status == 'tersedia')
                                    <span class="badge bg-success">Tersedia</span>
                                @else
                                    <span class="badge bg-danger">Tidak Tersedia</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        /* Responsive Chart */
        @media (max-width: 768px) {
            canvas {
                max-width: 100%;
                height: auto;
            }
        }
    </style>

    <!-- Grafik Transaksi -->
    <div class="mt-4 fade-in">
        <h4>Grafik Transaksi</h4>
        <div style="max-width: 800px; margin: auto;">
            <canvas id="transactionChart" width="800" height="400"></canvas>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('transactionChart').getContext('2d');

        // Gradient untuk warna bar
        const gradientBarang = ctx.createLinearGradient(0, 0, 0, 400);
        gradientBarang.addColorStop(0, 'rgba(13, 110, 253, 0.8)'); // Biru
        gradientBarang.addColorStop(1, 'rgba(13, 110, 253, 0.2)');

        const gradientMasuk = ctx.createLinearGradient(0, 0, 0, 400);
        gradientMasuk.addColorStop(0, 'rgba(25, 135, 84, 0.8)'); // Hijau
        gradientMasuk.addColorStop(1, 'rgba(25, 135, 84, 0.2)');

        const gradientKeluar = ctx.createLinearGradient(0, 0, 0, 400);
        gradientKeluar.addColorStop(0, 'rgba(220, 53, 69, 0.8)'); // Merah
        gradientKeluar.addColorStop(1, 'rgba(220, 53, 69, 0.2)');

        const transactionChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Barang', 'Transaksi Masuk', 'Transaksi Keluar'],
                datasets: [{
                    label: 'Jumlah',
                    data: [{{ $dataGrafik['barang'] }}, {{ $dataGrafik['transaksi_masuk'] }},
                        {{ $dataGrafik['transaksi_keluar'] }}
                    ],
                    backgroundColor: [
                        gradientBarang,
                        gradientMasuk,
                        gradientKeluar
                    ],
                    borderColor: ['#0d6efd', '#198754', '#dc3545'],
                    borderWidth: 1,
                    borderRadius: 5, // Sudut melengkung
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Agar grafik responsif
                plugins: {
                    legend: {
                        display: false, // Sembunyikan legenda
                    },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw}`;
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: (value) => value, // Menampilkan angka di atas bar
                        color: '#000',
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false // Hilangkan garis grid di sumbu X
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false // Hilangkan garis tepi di sumbu Y
                        },
                        ticks: {
                            stepSize: 1 // Interval angka di sumbu Y
                        }
                    }
                },
                animation: {
                    duration: 1000, // Animasi selama 1 detik
                    easing: 'easeInOutQuad' // Efek animasi halus
                }
            }
        });
    </script>

    <!-- Notifikasi Stok Kritis -->
    @if ($barangStokTerendah->where('stok_barang', '<=', 5)->count() > 0)
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: 'Ada barang dengan stok mendekati habis.',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endsection
