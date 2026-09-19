<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800"><?= esc($title) ?></h2>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center" role="alert">
        <i class="bi bi-check-circle-fill fs-5 me-2 text-success"></i>
        <div class="flex-grow-1"><?= session()->getFlashdata('success') ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center" role="alert">
        <i class="bi bi-exclamation-circle-fill fs-5 me-2 text-danger"></i>
        <div class="flex-grow-1"><?= session()->getFlashdata('error') ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-0 py-3">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-tags me-2 text-primary"></i>Daftar Kategori <?= esc(ucfirst($type)) ?></h5>
            <div class="d-flex flex-column flex-md-row gap-2 align-items-md-center">
                <a href="<?= base_url('admin/' . esc($type)) ?>" class="btn btn-light btn-sm border shadow-sm rounded-pill px-3 hover-lift">
                    <i class="bi bi-arrow-left me-1 text-primary"></i> Kembali
                </a>
                <a href="<?= base_url('admin/categories/' . esc($type) . '/create') ?>" class="btn btn-primary btn-sm shadow-sm rounded-pill px-3 hover-lift">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive px-2 pb-3">
            <table class="table table-hover align-middle border-bottom mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 text-muted text-uppercase fw-semibold text-center" style="font-size: 0.8rem;" width="5%">No</th>
                        <th class="py-3 text-muted text-uppercase fw-semibold" style="font-size: 0.8rem;">Nama Kategori</th>
                        <th class="py-3 text-muted text-uppercase fw-semibold text-center" style="font-size: 0.8rem;">Slug</th>
                        <th class="py-3 text-muted text-uppercase fw-semibold" style="font-size: 0.8rem;">Deskripsi</th>
                        <th class="py-3 text-muted text-uppercase fw-semibold text-center" style="font-size: 0.8rem;" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php if (empty($categories)) : ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center text-muted">
                                    <i class="bi bi-inbox fs-1 mb-2 text-light-subtle"></i>
                                    <p class="mb-0 fw-medium">Belum ada data kategori.</p>
                                    <small>Silakan tambahkan kategori baru melalui tombol di atas.</small>
                                </div>
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php $no = 1; foreach ($categories as $category) : ?>
                            <tr>
                                <td class="py-3 text-center"><?= $no++ ?></td>
                                <td class="py-3 fw-bold text-dark"><?= esc($category['name']) ?></td>
                                <td class="py-3 text-center">
                                    <span class="badge bg-light text-secondary border px-2 py-1 rounded-pill fw-normal">
                                        <i class="bi bi-tag-fill me-1 text-light-subtle"></i> <?= esc($category['slug']) ?>
                                    </span>
                                </td>
                                <td class="py-3 text-muted"><?= esc($category['description']) ?: '<em class="text-light-subtle">Tidak ada deskripsi</em>' ?></td>
                                <td class="py-3 text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="<?= base_url('admin/categories/edit/' . $category['id']) ?>" class="btn btn-sm btn-light text-primary border rounded-circle shadow-sm" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <a href="<?= base_url('admin/categories/delete/' . $category['id']) ?>" class="btn btn-sm btn-light text-danger border rounded-circle shadow-sm" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;" onclick="return confirmDelete(event, '<?= addslashes($category['name']) ?>', 'Kategori')" title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
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
