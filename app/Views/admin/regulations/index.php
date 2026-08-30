<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 fw-bold">Kelola Regulasi</h1>
        <p class="text-muted mb-0">Kelola dokumen regulasi & dasar hukum PPID.</p>
    </div>
</div>

<?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-0 py-3">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-journal-text me-2 text-primary"></i>Daftar Regulasi & Dasar Hukum</h5>
            <div class="d-flex flex-column flex-md-row gap-2 align-items-md-center">
                <form action="" method="get" class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                    <select name="type" class="form-select form-select-sm" onchange="this.form.submit()" style="max-width: 180px;">
                        <option value="">Semua Kategori</option>
                        <?php if (!empty($categories)) : ?>
                            <?php foreach ($categories as $cat) : ?>
                                <option value="<?= esc($cat['slug']) ?>" <?= ($type ?? '') == $cat['slug'] ? 'selected' : '' ?>>
                                    <?= esc($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </form>
                <a href="<?= base_url('admin/categories/regulations') ?>" class="btn btn-light btn-sm border shadow-sm rounded-pill px-3 ms-md-2 hover-lift">
                    <i class="bi bi-tags me-1 text-primary"></i> Kelola Kategori
                </a>
                <a href="<?= base_url('admin/regulations/create') ?>" class="btn btn-primary btn-sm shadow-sm rounded-pill px-3 hover-lift">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Regulasi
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
                        <th class="py-3 text-muted text-uppercase fw-semibold" style="font-size: 0.8rem;" width="35%">Judul / Tentang</th>
                        <th class="py-3 text-muted text-uppercase fw-semibold text-center" style="font-size: 0.8rem;" width="15%">Kategori</th>
                        <th class="py-3 text-muted text-uppercase fw-semibold" style="font-size: 0.8rem;" width="15%">Nomor & Tahun</th>
                        <th class="py-3 text-muted text-uppercase fw-semibold text-center" style="font-size: 0.8rem;" width="15%">File PDF</th>
                        <th class="py-3 text-muted text-uppercase fw-semibold text-center" style="font-size: 0.8rem;" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($regulations)) : ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center text-muted">
                                    <i class="bi bi-inbox fs-1 mb-3 text-secondary opacity-50"></i>
                                    <h5 class="fw-bold mb-1">Belum Ada Regulasi</h5>
                                    <p class="small mb-0">Saat ini tidak ada data regulasi yang tersedia.</p>
                                </div>
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php 
                        $page = $pager->getCurrentPage();
                        $no = 1 + (10 * ($page - 1));
                        foreach ($regulations as $item) : 
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= esc($item['title']) ?></div>
                                    <div class="small text-muted mb-1"><i class="bi bi-link-45deg"></i> /regulasi/<?= esc($item['slug'] ?? '...') ?></div>
                                    <?php if (!empty($item['description'])) : ?>
                                        <div class="small text-muted text-truncate" style="max-width: 300px;"><?= esc($item['description']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $label = '';
                                    if (!empty($item['type'])) {
                                        $label = strtoupper($item['type']);
                                        if (!empty($categories)) {
                                            foreach ($categories as $cat) {
                                                if ($cat['slug'] === $item['type']) {
                                                    $label = $cat['name'];
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                    <?php if ($label): ?>
                                        <span class="badge bg-primary px-2 py-1"><?= esc($label) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($item['number']) : ?>
                                        <div class="small fw-medium">No: <?= esc($item['number']) ?></div>
                                    <?php endif; ?>
                                    <?php if ($item['year']) : ?>
                                        <div class="small">Tahun: <?= esc($item['year']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (!empty($item['file_path'])) : ?>
                                        <a href="<?= base_url($item['file_path']) ?>" target="_blank" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-file-earmark-pdf"></i> PDF
                                        </a>
                                    <?php else : ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="<?= base_url('admin/regulations/edit/' . $item['id']) ?>" class="btn btn-sm btn-light text-primary border rounded-circle shadow-sm" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-light text-danger border rounded-circle shadow-sm btn-delete" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;" data-id="<?= $item['id'] ?>" data-title="<?= esc($item['title']) ?>" title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if ($pager->getPageCount() > 1) : ?>
    <div class="card-footer bg-white border-top-0 pt-3 pb-2">
        <?= $pager->links('default', 'bootstrap_pagination') ?>
    </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const title = this.getAttribute('data-title');
            
            Swal.fire({
                title: 'Konfirmasi Hapus',
                html: `Apakah Anda yakin ingin menghapus regulasi <strong>${title}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url('admin/regulations/delete/') ?>' + id;
                }
            });
        });
    });
});
</script>

<?= $this->endSection() ?>
