<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Pengguna Baru</h1>
    <a href="<?= base_url('admin/users') ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<?php if (session()->getFlashdata('errors')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Terjadi Kesalahan:</strong>
        <ul class="mb-0 mt-2">
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="m-0 font-weight-bold text-dark">Informasi Akun</h6>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('admin/users/store') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <label for="name" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="name" name="name" value="<?= old('name') ?>" required placeholder="Masukkan nama lengkap...">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                                <input type="email" class="form-control border-start-0 ps-0" id="email" name="email" value="<?= old('email') ?>" required placeholder="email@contoh.com">
                            </div>
                            <div class="form-text small">Digunakan untuk login ke sistem.</div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <label for="password" class="form-label fw-semibold">Password Akses <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-key text-muted"></i></span>
                                <input type="password" class="form-control border-start-0 border-end-0 ps-0" id="password" name="password" required minlength="6" placeholder="Minimal 6 karakter">
                                <button class="btn btn-outline-secondary border-start-0" type="button" id="btn-toggle-password" tabindex="-1">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="role" class="form-label fw-semibold">Role / Hak Akses <span class="text-danger">*</span></label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin" <?= old('role') == 'admin' ? 'selected' : '' ?>>Administrator (Akses penuh)</option>
                                <option value="pimpinan" <?= old('role') == 'pimpinan' ? 'selected' : '' ?>>Pimpinan (Akses read-only/laporan)</option>
                            </select>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded border mb-4">
                        <div class="form-check form-switch form-switch-md d-flex align-items-center mb-0 p-0">
                            <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="is_active" name="is_active" value="1" <?= old('is_active', '1') == '1' ? 'checked' : '' ?> style="margin-left: 0;">
                            <label class="form-check-label fw-semibold text-dark m-0 pt-1" for="is_active">
                                Aktifkan Akun
                                <div class="small fw-normal text-muted mt-1">Jika dinonaktifkan, pengguna ini tidak dapat login ke sistem.</div>
                            </label>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-light border fw-medium px-4">Reset Form</button>
                        <button type="submit" class="btn btn-primary fw-bold px-4">
                            <i class="bi bi-check2-circle me-1"></i> Simpan Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.form-switch-md .form-check-input {
    width: 2.5em;
    height: 1.25em;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const toggleBtn = document.getElementById('btn-toggle-password');
    const icon = toggleBtn.querySelector('i');
    
    toggleBtn.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
});
</script>

<?= $this->endSection() ?>
