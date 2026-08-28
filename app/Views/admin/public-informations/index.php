<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kelola Informasi Publik</h1>
    <div>
        <a href="<?= base_url('admin/categories/public-informations') ?>" class="btn btn-outline-secondary me-2">
            <i class="bi bi-tags me-1"></i> Kelola Kategori
        </a>
        <a href="<?= base_url('admin/public-informations/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Tambah Informasi
        </a>
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

<!-- Nav Tabs for Categories -->
<ul class="nav nav-tabs mb-4 border-bottom-0" role="tablist">
    <?php if (!empty($categories)) : ?>
        <?php foreach ($categories as $cat) : ?>
            <li class="nav-item" role="presentation">
                <a href="<?= base_url('admin/public-informations?category=' . esc($cat['slug'])) ?>" 
                   class="nav-link <?= $active_category == $cat['slug'] ? 'active fw-bold' : 'text-muted' ?>" 
                   style="<?= $active_category == $cat['slug'] ? 'border-top: 3px solid var(--primary-color, #1B5E20);' : '' ?>">
                    <i class="bi bi-folder2-open me-1"></i> <?= esc($cat['name']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>

<div class="card shadow-sm border-0 border-top border-3 border-primary">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="40%">Judul Informasi</th>
                        <th width="15%">Sub Kategori</th>
                        <th width="10%" class="text-center">Tahun</th>
                        <th width="15%" class="text-center">File Lampiran</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($informations)) : ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-folder-x fs-1 d-block mb-2 text-black-50"></i>
                                Belum ada data informasi publik untuk kategori ini.
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php 
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $no = 1 + (10 * ($page - 1));
                        foreach ($informations as $item) : 
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= esc($item['title']) ?></div>
                                    <?php if (!empty($item['description'])) : ?>
                                        <div class="small text-muted text-truncate" style="max-width: 350px;"><?= esc($item['description']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($item['sub_category'])) : ?>
                                        <span class="badge bg-light text-dark border"><?= esc($item['sub_category']) ?></span>
                                    <?php else : ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?= $item['year'] ? esc($item['year']) : '<span class="text-muted small">-</span>' ?>
                                </td>
                                <td class="text-center">
                                    <?php if (!empty($item['file_path'])) : ?>
                                        <a href="<?= base_url($item['file_path']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                    <?php else : ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('admin/public-informations/edit/' . $item['id']) ?>" class="btn btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-delete" data-id="<?= $item['id'] ?>" data-title="<?= esc($item['title']) ?>" title="Hapus">
                                            <i class="bi bi-trash"></i>
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
                html: `Apakah Anda yakin ingin menghapus informasi <strong>${title}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url('admin/public-informations/delete/') ?>' + id;
                }
            });
        });
    });
});
</script>

<?= $this->endSection() ?>
