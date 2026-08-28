<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kelola Halaman</h1>
    <a href="<?= base_url('admin/pages/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Halaman
    </a>
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

<div class="card shadow-sm mb-4">
    <div class="card-header py-3 bg-white border-bottom">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2">
            <h6 class="m-0 font-weight-bold">Daftar Halaman Statis</h6>
            <form action="" method="get" class="d-flex align-items-center flex-wrap" style="gap: 8px;">
                <input type="text" name="search" class="form-control form-control-sm" style="max-width: 180px;"
                       placeholder="Cari judul..." value="<?= esc($search ?? '') ?>">
                <select name="category" class="form-select form-select-sm" style="max-width: 160px;">
                    <option value="">Semua Kategori</option>
                    <option value="profil_kanwil" <?= ($category ?? '') == 'profil_kanwil' ? 'selected' : '' ?>>Profil Kanwil</option>
                    <option value="profil_ppid" <?= ($category ?? '') == 'profil_ppid' ? 'selected' : '' ?>>Profil PPID</option>
                    <option value="standar_layanan" <?= ($category ?? '') == 'standar_layanan' ? 'selected' : '' ?>>Standar Layanan</option>
                    <option value="layanan_informasi" <?= ($category ?? '') == 'layanan_informasi' ? 'selected' : '' ?>>Layanan Informasi</option>
                </select>
                <select name="status" class="form-select form-select-sm" style="max-width: 130px;">
                    <option value="">Semua Status</option>
                    <option value="1" <?= ($status ?? '') === '1' ? 'selected' : '' ?>>Aktif</option>
                    <option value="0" <?= ($status ?? '') === '0' ? 'selected' : '' ?>>Nonaktif</option>
                </select>
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="bi bi-search"></i>
                </button>
                <?php if (!empty($search) || !empty($category) || ($status !== null && $status !== '')) : ?>
                    <a href="<?= base_url('admin/pages') ?>" class="btn btn-sm btn-outline-secondary" title="Reset filter">
                        <i class="bi bi-x-lg"></i>
                    </a>
                <?php endif; ?>
            </form>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="35%">Judul</th>
                        <th width="20%">Kategori</th>
                        <th width="10%" class="text-center">Urutan</th>
                        <th width="15%" class="text-center">Status</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pages)) : ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data halaman.</td>
                        </tr>
                    <?php else : ?>
                        <?php 
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $no = 1 + (10 * ($page - 1));
                        foreach ($pages as $item) : 
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= esc($item['title']) ?></div>
                                    <div class="small text-muted">/<?= esc($item['slug']) ?></div>
                                </td>
                                <td>
                                    <?php
                                    $catLabels = [
                                        'profil_kanwil' => 'Profil Kanwil',
                                        'profil_ppid' => 'Profil PPID',
                                        'standar_layanan' => 'Standar Layanan',
                                        'layanan_informasi' => 'Layanan Informasi'
                                    ];
                                    $catClass = [
                                        'profil_kanwil' => 'bg-primary',
                                        'profil_ppid' => 'bg-success',
                                        'standar_layanan' => 'bg-info',
                                        'layanan_informasi' => 'bg-warning text-dark'
                                    ];
                                    $label = $catLabels[$item['category']] ?? $item['category'];
                                    $class = $catClass[$item['category']] ?? 'bg-secondary';
                                    ?>
                                    <span class="badge <?= $class ?>"><?= $label ?></span>
                                </td>
                                <td class="text-center"><?= $item['sort_order'] ?></td>
                                <td class="text-center">
                                    <?php if ($item['is_active']) : ?>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success">Aktif</span>
                                    <?php else : ?>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('admin/pages/edit/' . $item['id']) ?>" class="btn btn-outline-primary" title="Edit">
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
                html: `Apakah Anda yakin ingin menghapus halaman <strong>${title}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url('admin/pages/delete/') ?>' + id;
                }
            });
        });
    });
});
</script>

<?= $this->endSection() ?>
