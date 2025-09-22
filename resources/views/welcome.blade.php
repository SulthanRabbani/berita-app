<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Berita App') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-newspaper"></i> Berita App
            </a>

            <div class="navbar-nav ms-auto">
                @auth
                    <a href="{{ url('/dashboard') }}" class="nav-link">
                        <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="nav-link">
                        <i class="fas fa-sign-in-alt me-1"></i>Login
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
            <div class="col-lg-8 text-center">
                <div class="mb-5">
                    <h1 class="display-4 fw-bold text-primary mb-3">
                        <i class="fas fa-newspaper"></i> Berita App
                    </h1>
                    <p class="lead text-muted">
                        Platform berita modern dengan sistem manajemen konten yang powerful
                    </p>
                </div>

                <div class="row mb-5">
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="text-primary mb-3">
                                    <i class="fas fa-newspaper fa-3x"></i>
                                </div>
                                <h5 class="card-title">Baca Artikel</h5>
                                <p class="card-text text-muted">
                                    Akses ribuan artikel berkualitas dari berbagai kategori
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="text-success mb-3">
                                    <i class="fas fa-comments fa-3x"></i>
                                </div>
                                <h5 class="card-title">Diskusi</h5>
                                <p class="card-text text-muted">
                                    Berpartisipasi dalam diskusi dan berikan komentar
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="text-warning mb-3">
                                    <i class="fas fa-bookmark fa-3x"></i>
                                </div>
                                <h5 class="card-title">Simpan Artikel</h5>
                                <p class="card-text text-muted">
                                    Simpan artikel favorit untuk dibaca nanti
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                @guest
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card shadow">
                                <div class="card-body p-4">
                                    <h5 class="card-title mb-3">Mulai Sekarang</h5>
                                    <p class="text-muted mb-4">
                                        Daftar sekarang untuk mengakses semua fitur platform kami
                                    </p>
                                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100">
                                        <i class="fab fa-google me-2"></i>
                                        Masuk dengan Google
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endguest

                @auth
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="alert alert-success">
                                <h5 class="alert-heading">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Selamat datang, {{ auth()->user()->name }}!
                                </h5>
                                <p class="mb-3">Anda sudah login dan dapat mengakses semua fitur.</p>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                                        <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                                    </a>
                                    <a href="#" class="btn btn-outline-primary">
                                        <i class="fas fa-list me-1"></i>Artikel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h6><i class="fas fa-newspaper me-1"></i> Berita App</h6>
                    <p class="text-muted mb-0">Platform berita modern dengan teknologi Laravel 11+</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">
                        © {{ date('Y') }} Berita App. Dibuat untuk Full Stack Developer Challenge.
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
        </header>
        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
