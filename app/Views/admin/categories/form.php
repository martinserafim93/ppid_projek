<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 fw-bold"><?= esc($title) ?></h1>
        <p class="text-muted mb-0">Lengkapi form di bawah ini untuk menyimpan data kategori.</p>
    </div>
    <a href="<?= base_url('admin/categories/' . esc($type)) ?>" class="btn btn-light border shadow-sm rounded-pill px-3 d-flex align-items-center">
        <i class="bi bi-arrow-left me-2"></i> Kembali
    </a>
</div>

<?php if (session()->has('errors')) : ?>
    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4" role="alert">
        <div class="d-flex align-items-center mb-2">
            <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
            <strong class="mb-0">Terjadi Kesalahan!</strong>
        </div>
        <ul class="mb-0 ps-4">
            <?php foreach (session('errors') as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4 p-xl-5">
        <?php $isEdit = isset($category); ?>
        <form action="<?= base_url('admin/categories/' . ($isEdit ? 'update/' . $category['id'] : 'store')) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="type" value="<?= esc($type) ?>">

            <div class="mb-4">
                <label for="name" class="form-label fw-semibold text-dark">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-lg bg-light border-0" id="name" name="name" 
                       value="<?= old('name', $category['name'] ?? '') ?>" required placeholder="Masukkan nama kategori">
            </div>

            <div class="mb-4">
                <label for="description" class="form-label fw-semibold text-dark">Deskripsi</label>
                <textarea class="form-control bg-light border-0" id="description" name="description" rows="4" placeholder="Penjelasan singkat mengenai kategori ini..."><?= old('description', $category['description'] ?? '') ?></textarea>
                <div class="form-text small mt-2"><i class="bi bi-info-circle me-1"></i>Opsional. Penjelasan singkat mengenai kategori ini.</div>
            </div>

            <hr class="my-5 text-secondary opacity-25">
            <div class="d-flex justify-content-end gap-3">
                <a href="<?= base_url('admin/categories/' . esc($type)) ?>" class="btn btn-light btn-lg border fw-medium px-4 rounded-pill">Batal</a>
                <button type="submit" class="btn btn-primary btn-lg fw-bold px-5 shadow-sm rounded-pill d-flex align-items-center">
                    <i class="bi bi-save-fill me-2 fs-5"></i> Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
