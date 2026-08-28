<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kelola Regulasi</h1>
    <a href="<?= base_url('admin/regulations/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Regulasi
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
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white">
        <h6 class="m-0 font-weight-bold">Daftar Regulasi & Dasar Hukum</h6>
        <form action="" method="get" class="d-flex align-items-center" style="gap: 10px;">
            <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Semua Tipe Regulasi</option>
                <option value="uu" <?= ($type ?? '') == 'uu' ? 'selected' : '' ?>>Undang-Undang (UU)</option>
                <option value="pp" <?= ($type ?? '') == 'pp' ? 'selected' : '' ?>>Peraturan Pemerintah (PP)</option>
                <option value="perki" <?= ($type ?? '') == 'perki' ? 'selected' : '' ?>>Peraturan KI (Perki)</option>
                <option value="pma" <?= ($type ?? '') == 'pma' ? 'selected' : '' ?>>Peraturan Menteri (PMA)</option>
                <option value="sk" <?= ($type ?? '') == 'sk' ? 'selected' : '' ?>>Surat Keputusan (SK)</option>
            </select>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="35%">Judul / Tentang</th>
                        <th width="15%" class="text-center">Tipe</th>
                        <th width="15%">Nomor & Tahun</th>
                        <th width="15%" class="text-center">File PDF</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($regulations)) : ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data regulasi.</td>
                        </tr>
                    <?php else : ?>
                        <?php 
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $no = 1 + (10 * ($page - 1));
                        foreach ($regulations as $item) : 
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= esc($item['title']) ?></div>
                                    <?php if (!empty($item['description'])) : ?>
                                        <div class="small text-muted text-truncate" style="max-width: 300px;"><?= esc($item['description']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $typeLabels = [
                                        'uu' => 'UU',
                                        'pp' => 'PP',
                                        'perki' => 'Perki',
                                        'pma' => 'PMA',
                                        'sk' => 'SK'
                                    ];
                                    $typeClass = [
                                        'uu' => 'bg-danger',
                                        'pp' => 'bg-warning text-dark',
                                        'perki' => 'bg-primary',
                                        'pma' => 'bg-success',
                                        'sk' => 'bg-info text-dark'
                                    ];
                                    $label = $typeLabels[$item['type']] ?? strtoupper($item['type']);
                                    $class = $typeClass[$item['type']] ?? 'bg-secondary';
                                    ?>
                                    <span class="badge <?= $class ?> px-2 py-1"><?= $label ?></span>
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
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('admin/regulations/edit/' . $item['id']) ?>" class="btn btn-outline-primary" title="Edit">
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
