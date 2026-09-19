<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<section class="py-5" style="background-color: var(--bg-light); min-height: 80vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <div class="card-glass border-0 shadow-sm" data-aos="fade-up" data-aos-duration="600">
                    <div class="p-4 p-md-5">
                        <div class="text-center mb-4">
                            <img src="<?= base_url('assets/img/kemenag-new-2025.png') ?>" alt="Logo Instansi" style="height: 50px;" class="mb-3">
                            <h3 class="heading-font fw-bold text-dark">Daftar Akun PPID</h3>
                            <p class="text-muted small">Pendaftaran diperlukan untuk mengajukan permohonan informasi. Isi formulir di bawah ini dengan data yang benar sesuai identitas.</p>
                        </div>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show border-0" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Terdapat kesalahan:
                                <ul class="mb-0 mt-2 text-start">
                                    <?= session()->getFlashdata('error') ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('user/register') ?>" method="POST" id="registerForm">
                            <?= csrf_field() ?>
                            
                            <div class="form-floating mb-3">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Sesuai KTP" value="<?= old('name') ?>" required minlength="3">
                                <label for="name">Nama Lengkap (Sesuai KTP)</label>
                            </div>
                            
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" name="email" class="form-control" id="email" placeholder="nama@email.com" value="<?= old('email') ?>" required>
                                        <label for="email">Alamat Email</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" name="phone" class="form-control" id="phone" placeholder="08..." value="<?= old('phone') ?>" required minlength="10">
                                        <label for="phone">Nomor Telepon / WA</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mb-1">
                                <input type="text" name="nik" class="form-control" id="nik" placeholder="16 Digit NIK" value="<?= old('nik') ?>" required pattern="[0-9]{16}" title="NIK harus berupa 16 digit angka">
                                <label for="nik">Nomor Induk Kependudukan (NIK)</label>
                            </div>
                            <div class="form-text text-muted small mb-3 ms-1"><i class="bi bi-info-circle me-1"></i>NIK wajib 16 digit angka.</div>
                            
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" name="password" class="form-control" id="password" placeholder="Minimal 8 karakter" required minlength="8">
                                        <label for="password">Kata Sandi</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Ketik ulang password" required minlength="8">
                                        <label for="confirm_password">Konfirmasi Sandi</label>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary-custom w-100 py-3 fw-semibold shadow-sm">
                                Daftar Sekarang <i class="bi bi-person-plus ms-2"></i>
                            </button>
                        </form>
                        
                        <div class="text-center mt-4">
                            <p class="text-muted small">Sudah punya akun? <a href="<?= base_url('user/login') ?>" class="text-success fw-bold text-decoration-none">Masuk di sini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->section('scripts') ?>
<script>
    // Simple client-side validation logic for NIK
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        var nikInput = document.getElementById('nik');
        var nikValue = nikInput.value.trim();
        if (!/^\d{16}$/.test(nikValue)) {
            e.preventDefault();
            alert('Nomor Induk Kependudukan (NIK) harus terdiri dari 16 digit angka yang valid.');
            nikInput.focus();
        }
        
        var pw = document.getElementById('password').value;
        var cpw = document.getElementById('confirm_password').value;
        if (pw !== cpw) {
            e.preventDefault();
            alert('Kata Sandi dan Konfirmasi Sandi tidak cocok.');
            document.getElementById('confirm_password').focus();
        }
    });
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
