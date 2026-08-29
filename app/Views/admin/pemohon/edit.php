<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Data Pemohon</h1>
    <a href="<?= base_url('admin/pemohon') ?>" class="btn btn-outline-secondary">
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
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-dark">Informasi Akun Pemohon</h6>
            </div>
            
            <div class="card-body p-4">
                <form action="<?= base_url('admin/pemohon/update/' . $user['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">Nama Lengkap (Sesuai KTP) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                            <input type="text" class="form-control border-start-0 ps-0" id="name" name="name" value="<?= old('name', $user['name']) ?>" required placeholder="Contoh: Budi Santoso">
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <label for="nik" class="form-label fw-semibold">NIK (Nomor Induk Kependudukan) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person-vcard text-muted"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="nik" name="nik" value="<?= old('nik', $user['nik']) ?>" required maxlength="16" placeholder="16 Digit Angka NIK">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold">Nomor Telepon / WhatsApp <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-whatsapp text-success opacity-75"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="phone" name="phone" value="<?= old('phone', $user['phone']) ?>" required placeholder="Contoh: 08123456789">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                            <input type="email" class="form-control border-start-0 ps-0" id="email" name="email" value="<?= old('email', $user['email']) ?>" required placeholder="email@contoh.com">
                        </div>
                        <div class="form-text small">Perubahan email akan digunakan untuk notifikasi permohonan informasi pemohon ini.</div>
                    </div>

                    <div class="p-3 bg-light rounded border mb-4">
                        <div class="form-check form-switch form-switch-md d-flex align-items-center mb-0 p-0">
                            <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="is_active" name="is_active" value="1" <?= old('is_active', $user['is_active']) == '1' ? 'checked' : '' ?> style="margin-left: 0;">
                            <label class="form-check-label fw-semibold text-dark m-0 pt-1" for="is_active">
                                Aktifkan Akun
                                <div class="small fw-normal text-muted mt-1">Jika dinonaktifkan, pemohon ini tidak dapat login ke sistem.</div>
                            </label>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            <i class="bi bi-info-circle me-1"></i> Gunakan tombol "Reset" di tabel daftar pemohon untuk mengubah password.
                        </div>
                        <button type="submit" class="btn btn-primary fw-bold px-4">
                            <i class="bi bi-check2-circle me-1"></i> Update Data
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

<?= $this->endSection() ?>
