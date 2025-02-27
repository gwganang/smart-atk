<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMart-ATK</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            height: 100vh;
            background-color: #0d6efd;
            color: white;
            transition: width 0.3s ease-in-out;
            overflow-y: auto;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 10px 15px;
            transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .sidebar a:hover {
            background-color: #0b5ed7;
            transform: translateX(5px);
        }

        .sidebar i {
            font-size: 1.2rem;
            margin-right: 10px;
        }

        .navbar-brand {
            font-weight: bold;
            color: #0d6efd !important;
        }

        .btn-custom {
            background-color: #0d6efd;
            border-color: #0d6efd;
            transition: transform 0.2s ease-in-out;
        }

        .btn-custom:hover {
            transform: scale(1.05);
        }

        .table-hover tbody tr:hover {
            background-color: #f1f8ff;
            transition: background-color 0.3s ease-in-out;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="d-flex">
        <div class="sidebar p-3">
            <h4 class="text-center mb-4 text-white">Menu</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('barang.index') }}" class="nav-link d-flex align-items-center">
                        <i class="fas fa-box"></i> Barang
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('transaksi.masuk.index') }}"
                        class="nav-link d-flex align-items-center 
                        {{ request()->is('transaksi/masuk*') ? 'bg-primary text-white' : '' }}">
                        <i class="fas fa-arrow-down"></i> Transaksi Masuk
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('transaksi.keluar.index') }}"
                        class="nav-link d-flex align-items-center 
                        {{ request()->is('transaksi/keluar*') ? 'bg-primary text-white' : '' }}">
                        <i class="fas fa-arrow-up"></i> Transaksi Keluar
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 p-4">
            <div class="container-fluid fade-in">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- SweetAlert Notifications -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
            });
        </script>
    @endif

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
