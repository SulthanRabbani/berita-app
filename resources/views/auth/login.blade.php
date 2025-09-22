<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Berita App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="card-title text-primary mb-2">
                                <i class="fas fa-newspaper"></i> Berita App
                            </h2>
                            <p class="text-muted">Silakan masuk dengan akun Google Anda</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <div class="d-grid">
                            <a href="{{ route('google.login') }}" class="btn btn-danger btn-lg">
                                <i class="fab fa-google me-2"></i>
                                Masuk dengan Google
                            </a>
                        </div>

                        <div class="text-center mt-4">
                            <small class="text-muted">
                                Dengan masuk, Anda menyetujui syarat dan ketentuan kami
                            </small>
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ url('/') }}" class="text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i>
                                Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>