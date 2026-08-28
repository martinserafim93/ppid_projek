<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — PPID Kaltara</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Auth CSS -->
    <link href="/css/auth.css" rel="stylesheet">
</head>
<body>
    <div class="auth-wrapper container">
        <div class="auth-card row g-0">
            <!-- Sidebar / Branding -->
            <div class="col-md-5 auth-sidebar">
                <img src="/assets/img/kemenag-new-2025.png" alt="Logo Instansi" class="logo">
                <h2>PPID Kaltara</h2>
                <p>Layanan Informasi Publik Terpadu Pemerintah Provinsi Kalimantan Utara.</p>
            </div>
            
            <!-- Form -->
            <div class="col-md-7 auth-form-wrapper">
                <h3>Selamat Datang!</h3>
                <p class="text-muted">Silakan masuk ke akun Anda untuk melanjutkan.</p>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/auth/login">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password Anda" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Log In</button>
                </form>
                
                <p class="text-center mt-4 mb-0">
                    Belum punya akun? <a href="/auth/register" class="auth-link">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
