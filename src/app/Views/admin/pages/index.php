<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Kelola Halaman</h2>
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
            <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-file-earmark-richtext me-2 text-primary"></i>Daftar Halaman Statis</h5>
            <div class="d-flex flex-column flex-md-row gap-2 align-items-md-center">
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
            <a href="<?= base_url('admin/pages/create') ?>" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-lift ms-md-2">
                <i class="bi bi-plus-lg me-1"></i> Tambah Halaman
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
                        <th class="py-3 text-muted text-uppercase fw-semibold" style="font-size: 0.8rem;" width="35%">Judul</th>
                        <th class="py-3 text-muted text-uppercase fw-semibold" style="font-size: 0.8rem;" width="20%">Kategori</th>
                        <th class="py-3 text-muted text-uppercase fw-semibold text-center" style="font-size: 0.8rem;" width="10%">Urutan</th>
                        <th class="py-3 text-muted text-uppercase fw-semibold text-center" style="font-size: 0.8rem;" width="15%">Status</th>
                        <th class="py-3 text-muted text-uppercase fw-semibold text-center" style="font-size: 0.8rem;" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pages)) : ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center text-muted">
                                    <i class="bi bi-inbox fs-1 mb-3 text-secondary opacity-50"></i>
                                    <h5 class="fw-bold mb-1">Belum Ada Halaman</h5>
                                    <p class="small mb-3">Saat ini tidak ada data halaman statis yang tersedia.</p>
                                    <a href="<?= base_url('admin/pages/create') ?>" class="btn btn-outline-primary btn-sm rounded-pill hover-lift">
                                        <i class="bi bi-plus-lg me-1"></i> Buat Halaman
                                    </a>
                                </div>
                            </td>
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
                                        'profil_ppid' => 'bg-primary',
                                        'standar_layanan' => 'bg-gold text-dark',
                                        'layanan_informasi' => 'bg-success'
                                    ];
                                    $label = $catLabels[$item['category']] ?? $item['category'];
                                    $class = $catClass[$item['category']] ?? 'bg-secondary';
                                    ?>
                                    <span class="badge <?= $class ?> px-2 py-1 rounded-pill"><?= $label ?></span>
                                </td>
                                <td class="text-center"><?= $item['sort_order'] ?></td>
                                <td class="text-center">
                                    <?php if ($item['is_active']) : ?>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success px-2 py-1 rounded-pill">Aktif</span>
                                    <?php else : ?>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary px-2 py-1 rounded-pill">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="<?= base_url('admin/pages/edit/' . $item['slug']) ?>" class="btn btn-sm btn-light text-primary border rounded-circle shadow-sm" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-light text-danger border rounded-circle shadow-sm btn-delete" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;" data-id="<?= $item['slug'] ?>" data-title="<?= esc($item['title']) ?>" title="Hapus">
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
