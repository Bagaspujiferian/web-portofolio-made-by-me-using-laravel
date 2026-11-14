<!doctype html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>Admin Login — BagasDev. Portfolio CMS</title>
    <!-- Tabler Core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css" rel="stylesheet"/>
</head>
<body class="d-flex flex-column bg-dark">
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <a href="{{ route('portfolio.index') }}" class="navbar-brand navbar-brand-autodark fs-1 fw-bold text-white text-decoration-none">
                    <span class="text-azure">&gt;_</span> BagasDev. <span class="badge bg-azure-lt ms-1">CMS</span>
                </a>
            </div>

            <div class="card card-md shadow-lg border-secondary">
                <div class="card-body">
                    <h2 class="h2 text-center mb-2">Login Dashboard Admin</h2>
                    <p class="text-secondary text-center mb-4">Kelola Proyek, Sertifikat, Profil 3D ID Card &amp; Moderasi Buku Tamu</p>

                    @if(session('admin_success'))
                        <div class="alert alert-success">{{ session('admin_success') }}</div>
                    @endif

                    @if(isset($errors) && $errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('admin.login.submit') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email Admin</label>
                            <input type="email" name="email" value="{{ old('email', 'admin@bagas.dev') }}" class="form-control" placeholder="admin@bagas.dev" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Password
                                <span class="form-label-description text-azure">Default: password123</span>
                            </label>
                            <input type="password" name="password" value="password123" class="form-control" placeholder="Masukkan password admin" required>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">
                                Masuk ke Dashboard CMS
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center text-secondary mt-3">
                <a href="{{ route('portfolio.index') }}" class="text-azure text-decoration-none">&larr; Kembali ke Halaman Portofolio Publik</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
</body>
</html>
