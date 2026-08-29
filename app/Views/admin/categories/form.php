<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= esc($title) ?></h1>
    <a href="<?= base_url('admin/categories/' . esc($type)) ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<?php if (session()->has('errors')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            <?php foreach (session('errors') as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <?php $isEdit = isset($category); ?>
        <form action="<?= base_url('admin/categories/' . ($isEdit ? 'update/' . $category['id'] : 'store')) ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="type" value="<?= esc($type) ?>">

            <div class="mb-4">
                <label for="name" class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="<?= old('name', $category['name'] ?? '') ?>" required>
            </div>

            <div class="mb-4">
                <label for="description" class="form-label fw-semibold">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= old('description', $category['description'] ?? '') ?></textarea>
                <div class="form-text">Opsional. Penjelasan singkat mengenai kategori ini.</div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="<?= base_url('admin/categories/' . esc($type)) ?>" class="btn btn-light">Batal</a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
