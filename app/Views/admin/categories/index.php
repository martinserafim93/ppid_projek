<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 fw-bold"><?= esc($title) ?></h1>
        <p class="text-muted mb-0">Kelola daftar kategori tipe untuk mengelompokkan data secara terstruktur.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= base_url('admin/' . esc($type)) ?>" class="btn btn-light border shadow-sm rounded-pill px-3 d-flex align-items-center">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
        <a href="<?= base_url('admin/categories/' . esc($type) . '/create') ?>" class="btn btn-primary shadow-sm rounded-pill px-4 d-flex align-items-center fw-medium">
            <i class="bi bi-plus-circle-fill me-2"></i> Tambah Kategori
        </a>
    </div>
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

<div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-dark">
                    <tr>
                        <th class="px-4 py-3 fw-semibold border-bottom-0 text-muted" width="5%">No</th>
                        <th class="py-3 fw-semibold border-bottom-0 text-muted">Nama Kategori</th>
                        <th class="py-3 fw-semibold border-bottom-0 text-muted">Slug</th>
                        <th class="py-3 fw-semibold border-bottom-0 text-muted">Deskripsi</th>
                        <th class="text-center py-3 fw-semibold border-bottom-0 text-muted" width="15%">Aksi</th>
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
                                <td class="px-4 py-3 text-muted"><?= $no++ ?></td>
                                <td class="py-3 fw-bold text-dark"><?= esc($category['name']) ?></td>
                                <td class="py-3">
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
