<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Kelola Permohonan Informasi</h2>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i> <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle me-1"></i> <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-file-earmark-text me-2 text-primary"></i>Daftar Permohonan</h5>
            <a href="<?= base_url('admin/requests/create') ?>" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm hover-lift">
                <i class="bi bi-plus-lg me-1"></i> Tambah Permohonan
            </a>
        </div>
    <div class="card-body">
        <div class="table-responsive px-2 pb-3">
            <table class="table table-hover align-middle border-bottom" id="dataTable" width="100%" cellspacing="0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 text-muted text-uppercase fw-semibold" style="font-size: 0.8rem;" width="5%">No</th>
                        <th class="py-3 text-muted text-uppercase fw-semibold" style="font-size: 0.8rem;" width="20%">No. Tiket</th>
                        <th class="py-3 text-muted text-uppercase fw-semibold" style="font-size: 0.8rem;" width="20%">Pemohon</th>
                        <th class="py-3 text-muted text-uppercase fw-semibold" style="font-size: 0.8rem;" width="25%">Subjek</th>
                        <th class="py-3 text-muted text-uppercase fw-semibold" style="font-size: 0.8rem;" width="10%">Tanggal</th>
                        <th class="py-3 text-muted text-uppercase fw-semibold" style="font-size: 0.8rem;" width="10%">Status</th>
                        <th class="py-3 text-muted text-uppercase fw-semibold" style="font-size: 0.8rem;" width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($requests)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center text-muted">
                                    <i class="bi bi-inbox fs-1 mb-3 text-secondary opacity-50"></i>
                                    <h5 class="fw-bold mb-1">Belum Ada Permohonan</h5>
                                    <p class="small mb-3">Saat ini tidak ada data permohonan informasi yang masuk.</p>
                                    <a href="<?= base_url('admin/requests/create') ?>" class="btn btn-outline-primary btn-sm rounded-pill hover-lift">
                                        <i class="bi bi-plus-lg me-1"></i> Buat Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $i = 1; foreach ($requests as $req): ?>
                            <tr>
                                <td class="text-center"><?= $i++ ?></td>
                                <td><span class="fw-bold"><?= esc($req['ticket_number']) ?></span></td>
                                <td>
                                    <?= esc($req['user_name']) ?><br>
                                    <small class="text-muted"><?= esc($req['email']) ?></small>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 250px;">
                                        <?= esc($req['subject']) ?>
                                    </div>
                                </td>
                                <td>
                                    <small><?= formatWita($req['created_at'], 'd/m/Y') ?><br><?= formatWita($req['created_at'], 'H:i') ?> WITA</small>
                                </td>
                                <td>
                                    <?php 
                                        $status = $req['status'];
                                        $badgeClass = 'warning'; // Changed to warning so it demands attention
                                        $statusText = 'Pending';
                                        
                                        if($status == 'process') { $badgeClass = 'info'; $statusText = 'Diproses'; }
                                        else if($status == 'approved') { $badgeClass = 'success'; $statusText = 'Disetujui'; }
                                        else if($status == 'rejected') { $badgeClass = 'danger'; $statusText = 'Ditolak'; }
                                        else if($status == 'objection') { $badgeClass = 'dark'; $statusText = 'Keberatan'; }
                                    ?>
                                    <span class="badge bg-<?= $badgeClass ?> bg-opacity-10 text-<?= $badgeClass ?> border border-<?= $badgeClass ?> px-2 py-1 rounded-pill">
                                        <?= $statusText ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="<?= base_url('admin/requests/detail/' . $req['slug']) ?>" class="btn btn-sm btn-light text-primary border rounded-circle shadow-sm" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;" title="Detail">
                                            <i class="bi bi-search"></i>
                                        </a>
                                        <a href="<?= base_url('admin/requests/edit/' . $req['slug']) ?>" class="btn btn-sm btn-light text-warning border rounded-circle shadow-sm" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-light text-danger border rounded-circle shadow-sm btn-delete" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;" data-slug="<?= $req['slug'] ?>" data-title="<?= esc($req['ticket_number']) ?>" title="Hapus">
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
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const slug = this.getAttribute('data-slug');
                const title = this.getAttribute('data-title');
                
                Swal.fire({
                    title: 'Hapus Permohonan?',
                    text: 'Apakah Anda yakin ingin menghapus tiket ' + title + ' beserta seluruh lampirannya?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '<?= base_url('admin/requests/delete/') ?>' + slug;
                    }
                });
            });
        });
    });
</script>
<?= $this->endSection() ?>
