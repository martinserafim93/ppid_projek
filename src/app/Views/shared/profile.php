<?= $this->extend($layout) ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800" style="font-weight: 700; color: #333;">Profil Saya</h1>
            <p class="text-muted">Kelola informasi akun dan foto profil Anda</p>
        </div>
    </div>

    <!-- Error Handling -->
    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="alert alert-danger rounded-3 shadow-sm border-0 mb-4">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger rounded-3 shadow-sm border-0 mb-4">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif ?>

    <!-- Pimpinan vs Admin base URL route fix -->
    <?php 
        $rolePrefix = session()->get('user_role') === 'admin' ? 'admin' : 'pimpinan';
    ?>
    <form action="<?= base_url($rolePrefix . '/profile/update') ?>" method="post" enctype="multipart/form-data" id="profileForm">
        <?= csrf_field() ?>
        
        <div class="row">
            <!-- Left Column: Avatar -->
            <div class="col-xl-4 col-lg-5 mb-4">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body text-center p-4">
                        <h5 class="card-title mb-4" style="font-weight: 600; color: #333;">Foto Profil</h5>
                        
                        <div class="position-relative d-inline-block mb-4">
                            <?php if (!empty($user['avatar'])) : ?>
                                <img src="<?= base_url('uploads/avatars/' . $user['avatar']) ?>" id="avatarPreview" class="rounded-circle shadow-sm" style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #fff;">
                            <?php else : ?>
                                <div id="avatarPreviewInitials" class="rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 150px; height: 150px; background-color: #1B5E20; color: white; font-size: 3.5rem; font-weight: bold; border: 4px solid #fff; margin: 0 auto;">
                                    <?= substr(esc($user['name']), 0, 1) ?>
                                </div>
                                <img src="" id="avatarPreview" class="rounded-circle shadow-sm d-none" style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #fff;">
                            <?php endif; ?>
                            
                            <!-- Camera icon overlay -->
                            <label for="avatarInput" class="position-absolute bottom-0 end-0 bg-white rounded-circle p-2 shadow-sm" style="cursor: pointer; transition: transform 0.2s; border: 1px solid #eee;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                <i class="bi bi-camera-fill" style="color: #1B5E20; font-size: 1.2rem;"></i>
                            </label>
                        </div>
                        
                        <input type="file" name="avatar" id="avatarInput" class="d-none" accept=".png, .jpg, .jpeg">
                        
                        <p class="text-muted small mb-0">Format: JPG, JPEG, PNG.</p>
                        <p class="text-muted small">Ukuran maksimal: 2MB.</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Info & Password -->
            <div class="col-xl-8 col-lg-7 mb-4">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-body p-4 p-md-5">
                        <h5 class="card-title mb-4" style="font-weight: 600; color: #333;">Informasi Pribadi</h5>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted fw-medium">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" class="form-control bg-light border-start-0 ps-0" name="name" value="<?= esc(old('name', $user['name'])) ?>" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted fw-medium">Email (Tidak dapat diubah)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                                <input type="email" class="form-control bg-light border-start-0 ps-0 text-muted" value="<?= esc($user['email']) ?>" readonly style="cursor: not-allowed;">
                            </div>
                        </div>

                        <hr class="my-4" style="border-color: #eee;">

                        <h5 class="card-title mb-4" style="font-weight: 600; color: #333;">Ubah Password</h5>
                        <p class="text-muted small mb-4">Kosongkan jika Anda tidak ingin mengubah password saat ini.</p>

                        <div class="mb-3">
                            <label class="form-label text-muted fw-medium">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                                <input type="password" class="form-control bg-light border-start-0 border-end-0 ps-0" name="password" id="newPassword" placeholder="Minimal 8 karakter">
                                <button class="btn btn-light border-start-0 border" type="button" onclick="togglePassword('newPassword', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted fw-medium">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-shield-lock text-muted"></i></span>
                                <input type="password" class="form-control bg-light border-start-0 border-end-0 ps-0" name="password_confirm" id="confirmPassword" placeholder="Ulangi password baru">
                                <button class="btn btn-light border-start-0 border" type="button" onclick="togglePassword('confirmPassword', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4 pt-2">
                            <button type="submit" class="btn px-4 py-2 rounded-3 shadow-sm text-white" style="background-color: #1B5E20; font-weight: 500; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform='translateY(0)'">
                                <i class="bi bi-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Live preview avatar
    document.getElementById('avatarInput').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const file = e.target.files[0];
            
            // Validate size (2MB) before preview
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran Terlalu Besar',
                    text: 'Maksimal ukuran file foto adalah 2MB.'
                });
                this.value = ''; // Reset input
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('avatarPreview');
                const initialsDiv = document.getElementById('avatarPreviewInitials');
                
                previewImg.src = e.target.result;
                previewImg.classList.remove('d-none');
                
                if (initialsDiv) {
                    initialsDiv.classList.add('d-none');
                }
            }
            reader.readAsDataURL(file);
        }
    });

    // Toggle password visibility
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    // SweetAlert Success Trigger
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= esc(session()->getFlashdata('success')) ?>',
            timer: 3000,
            showConfirmButton: false
        });
    <?php endif; ?>
</script>
<?= $this->endSection() ?>
