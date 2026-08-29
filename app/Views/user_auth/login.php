<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - PPID Kaltara</title>
    
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
            background-image: url('<?= base_url('assets/img/pattern-bg.png') ?>'); /* Optional subtle pattern */
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .login-wrapper {
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }
        .card-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .btn-primary-custom {
            background-color: #1B5E20;
            border-color: #1B5E20;
            color: #fff;
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover {
            background-color: #2E7D32;
            border-color: #2E7D32;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.2);
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="text-center mb-4">
        <a href="<?= base_url() ?>">
            <img src="<?= base_url('assets/img/kemenag-new-2025.png') ?>" alt="Logo PPID" style="height: 60px;">
        </a>
    </div>

    <div class="card card-glass p-4 p-md-5">
        <h4 class="fw-bold mb-1 text-dark text-center">Masuk Akun</h4>
        <p class="text-muted mb-4 text-center">Masuk untuk mengajukan dan melacak permohonan informasi Anda.</p>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger border-0 d-flex align-items-center rounded-3">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div class="small"><?= session()->getFlashdata('error') ?></div>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success border-0 d-flex align-items-center rounded-3">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div class="small"><?= session()->getFlashdata('success') ?></div>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('user/login') ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required value="<?= old('email') ?>">
                <label for="email">Alamat Email</label>
            </div>
            
            <div class="form-floating mb-4">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="password">Kata Sandi</label>
            </div>
            
            <button type="submit" class="btn btn-primary-custom w-100 py-3 fw-bold rounded-3">
                Masuk <i class="bi bi-box-arrow-in-right ms-1"></i>
            </button>
        </form>
        
        <div class="text-center mt-4">
            <p class="text-muted small mb-0">Belum punya akun? <a href="<?= base_url('user/register') ?>" class="text-success fw-bold text-decoration-none">Daftar sekarang</a></p>
            <div class="mt-3">
                <a href="<?= base_url('/') ?>" class="text-muted text-decoration-none small"><i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
