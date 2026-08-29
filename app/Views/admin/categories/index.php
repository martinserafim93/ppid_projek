<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= esc($title) ?></h1>
    <div>
        <a href="<?= base_url('admin/' . esc($type)) ?>" class="btn btn-outline-secondary me-2">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        <a href="<?= base_url('admin/categories/' . esc($type) . '/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3" width="5%">No</th>
                        <th class="py-3">Nama Kategori</th>
                        <th class="py-3">Slug</th>
                        <th class="py-3">Deskripsi</th>
                        <th class="text-center py-3" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($categories)) : ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data kategori.</td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1; foreach ($categories as $category) : ?>
                            <tr>
                                <td class="px-4 text-muted"><?= $no++ ?></td>
                                <td class="fw-medium text-dark"><?= esc($category['name']) ?></td>
                                <td><span class="badge bg-light text-dark border"><?= esc($category['slug']) ?></span></td>
                                <td><?= esc($category['description']) ?: '<span class="text-muted fst-italic">Tidak ada deskripsi</span>' ?></td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('admin/categories/edit/' . $category['id']) ?>" class="btn btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="<?= base_url('admin/categories/delete/' . $category['id']) ?>" class="btn btn-outline-danger" onclick="return confirmDelete(event, '<?= addslashes($category['name']) ?>', 'Kategori')" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
