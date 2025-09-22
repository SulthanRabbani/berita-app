<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Berita App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-newspaper"></i> Berita App
            </a>

            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                        @else
                            <i class="fas fa-user-circle me-2"></i>
                        @endif
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'editor')
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-cog me-2"></i>Admin Panel</a></li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Dashboard
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>Selamat datang, {{ auth()->user()->name }}!</h5>
                                <p class="text-muted">Anda login sebagai: <span class="badge bg-primary">{{ ucfirst(auth()->user()->role) }}</span></p>

                                <div class="row mt-4">
                                    <div class="col-md-6 mb-3">
                                        <div class="card bg-info text-white">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <h6 class="card-title">Artikel Tersimpan</h6>
                                                        <h3>{{ auth()->user()->bookmarks()->count() }}</h3>
                                                    </div>
                                                    <div class="align-self-center">
                                                        <i class="fas fa-bookmark fa-2x"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="card bg-success text-white">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <h6 class="card-title">Komentar Saya</h6>
                                                        <h3>{{ auth()->user()->comments()->count() }}</h3>
                                                    </div>
                                                    <div class="align-self-center">
                                                        <i class="fas fa-comments fa-2x"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'editor')
                                        <div class="col-md-6 mb-3">
                                            <div class="card bg-warning text-white">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h6 class="card-title">Artikel Saya</h6>
                                                            <h3>{{ auth()->user()->articles()->count() }}</h3>
                                                        </div>
                                                        <div class="align-self-center">
                                                            <i class="fas fa-newspaper fa-2x"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-4">
                                    <h6>Quick Actions:</h6>
                                    <div class="btn-group" role="group">
                                        <a href="{{ url('/') }}" class="btn btn-outline-primary">
                                            <i class="fas fa-home me-1"></i>Beranda
                                        </a>
                                        <a href="#" class="btn btn-outline-info">
                                            <i class="fas fa-bookmark me-1"></i>Artikel Tersimpan
                                        </a>
                                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'editor')
                                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-success">
                                                <i class="fas fa-cog me-1"></i>Admin Panel
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Informasi Akun</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center mb-3">
                                            @if(auth()->user()->avatar)
                                                <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="rounded-circle mb-2" width="80" height="80">
                                            @else
                                                <i class="fas fa-user-circle fa-5x text-muted mb-2"></i>
                                            @endif
                                            <h6>{{ auth()->user()->name }}</h6>
                                            <small class="text-muted">{{ auth()->user()->email }}</small>
                                        </div>

                                        <hr>

                                        <div class="small">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Role:</span>
                                                <span class="badge bg-primary">{{ ucfirst(auth()->user()->role) }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Bergabung:</span>
                                                <span>{{ auth()->user()->created_at->format('d M Y') }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span>Terakhir login:</span>
                                                <span>{{ now()->format('d M Y H:i') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
