<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' - SMart-ATK' : 'SMart-ATK' }}</title>
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
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .sidebar i {
            font-size: 1.2rem;
            margin-right: 10px;
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

        /* Responsive Sidebar */
        @media (max-width: 768px) {
            .sidebar {
                position: absolute;
                z-index: 1000;
                width: 100%;
                height: auto;
                background-color: #0d6efd;
            }

            .sidebar ul {
                flex-direction: column;
                padding: 0;
            }

            .sidebar a {
                flex-direction: row;
                justify-content: space-between;
                padding: 10px 15px;
            }

            .sidebar i {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>
    <!-- Hamburger Menu untuk Mobile -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white d-block d-lg-none">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu"
                aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="d-flex">
        <div class="sidebar p-3 collapse d-lg-block" id="sidebarMenu">
            <!-- Logo -->
            <div class="text-center mb-4">
                <i class="fas fa-box-open fa-2x text-white"></i>
                <h4 class="mt-2 text-white">SMart-ATK</h4>
            </div>
            <ul class="nav flex-column">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link d-flex align-items-center 
                    {{ request()->is('/') ? 'active bg-primary text-white' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <!-- Barang -->
                <li class="nav-item">
                    <a href="{{ route('barang.index') }}"
                        class="nav-link d-flex align-items-center 
                    {{ request()->is('barang*') ? 'active bg-primary text-white' : '' }}">
                        <i class="fas fa-box"></i> Barang
                    </a>
                </li>
                <!-- Transaksi Masuk -->
                <li class="nav-item">
                    <a href="{{ route('transaksi.masuk.index') }}"
                        class="nav-link d-flex align-items-center 
                    {{ request()->is('transaksi/masuk*') ? 'active bg-primary text-white' : '' }}">
                        <i class="fas fa-arrow-down"></i> Transaksi Masuk
                    </a>
                </li>
                <!-- Transaksi Keluar -->
                <li class="nav-item">
                    <a href="{{ route('transaksi.keluar.index') }}"
                        class="nav-link d-flex align-items-center 
                    {{ request()->is('transaksi/keluar*') ? 'active bg-primary text-white' : '' }}">
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
