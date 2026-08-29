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
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle" id="dataTable" width="100%" cellspacing="0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">No. Tiket</th>
                        <th width="20%">Pemohon</th>
                        <th width="30%">Subjek</th>
                        <th width="10%">Tanggal</th>
                        <th width="10%">Status</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($requests)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada permohonan informasi.</td>
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
                                    <small><?= date('d/m/Y', strtotime($req['created_at'])) ?><br><?= date('H:i', strtotime($req['created_at'])) ?></small>
                                </td>
                                <td>
                                    <?php 
                                        $status = $req['status'];
                                        $badgeClass = 'secondary';
                                        $statusText = 'Pending';
                                        
                                        if($status == 'process') { $badgeClass = 'warning'; $statusText = 'Diproses'; }
                                        else if($status == 'approved') { $badgeClass = 'success'; $statusText = 'Disetujui'; }
                                        else if($status == 'rejected') { $badgeClass = 'danger'; $statusText = 'Ditolak'; }
                                        else if($status == 'objection') { $badgeClass = 'info'; $statusText = 'Keberatan'; }
                                    ?>
                                    <span class="badge bg-<?= $badgeClass ?> bg-opacity-10 text-<?= $badgeClass ?> border border-<?= $badgeClass ?> px-2 py-1 rounded-pill">
                                        <?= $statusText ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="<?= base_url('admin/requests/detail/' . $req['id']) ?>" class="btn btn-sm btn-outline-primary rounded-circle" title="Detail">
                                            <i class="bi bi-search"></i>
                                        </a>
                                        <a href="<?= base_url('admin/requests/edit/' . $req['id']) ?>" class="btn btn-sm btn-outline-warning rounded-circle" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="<?= base_url('admin/requests/delete/' . $req['id']) ?>" class="btn btn-sm btn-outline-danger rounded-circle" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus tiket ini berserta seluruh lampirannya?');">
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
