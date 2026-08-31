<?= $this->extend('layouts/pimpinan') ?>

<?= $this->section('content') ?>
<style>
    .badge-soft-warning { background-color: rgba(255, 193, 7, 0.2); color: #997404; }
    .badge-soft-info { background-color: rgba(13, 202, 240, 0.2); color: #087f98; }
    .badge-soft-success { background-color: rgba(25, 135, 84, 0.2); color: #0f5132; }
    .badge-soft-danger { background-color: rgba(220, 53, 69, 0.2); color: #842029; }
    
    .table-hover tbody tr { transition: background-color 0.2s; }
    .table-hover tbody tr:hover { background-color: #f8f9fa; }
    
    .filter-card {
        background: white;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
    }
</style>

<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1A237E;">Monitoring Permohonan</h4>
            <p class="text-muted mb-0">Pantau status dan riwayat seluruh permohonan informasi</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-card mb-4">
        <form action="<?= current_url() ?>" method="GET" class="row g-3 align-items-center">
            <div class="col-md-3">
                <label class="form-label text-muted small fw-medium mb-1">Status</label>
                <select name="status" class="form-select border-0 bg-light">
                    <option value="">Semua Status</option>
                    <option value="pending" <?= ($status == 'pending') ? 'selected' : '' ?>>Menunggu</option>
                    <option value="process" <?= ($status == 'process') ? 'selected' : '' ?>>Diproses</option>
                    <option value="approved" <?= ($status == 'approved') ? 'selected' : '' ?>>Disetujui</option>
                    <option value="rejected" <?= ($status == 'rejected') ? 'selected' : '' ?>>Ditolak</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label text-muted small fw-medium mb-1">Pencarian</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-light border-0" placeholder="Cari no. tiket, pemohon, subjek..." value="<?= esc($search ?? '') ?>">
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2 mt-md-0 mt-3 pt-md-4">
                <button type="submit" class="btn btn-primary px-4 w-100" style="border-radius: 8px;">Terapkan</button>
                <?php if(!empty($search) || !empty($status)): ?>
                    <a href="<?= current_url() ?>" class="btn btn-light" style="border-radius: 8px;" title="Reset Filter">
                        <i class="bi bi-x-lg"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 border-0 rounded-start" width="5%">No</th>
                            <th class="border-0" width="15%">No. Tiket</th>
                            <th class="border-0" width="15%">Tanggal</th>
                            <th class="border-0" width="25%">Pemohon</th>
                            <th class="border-0" width="25%">Subjek Informasi</th>
                            <th class="border-0 rounded-end" width="15%">Status</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php if (empty($requests)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3" style="width: 80px; height: 80px;">
                                        <i class="bi bi-inbox text-muted fs-1"></i>
                                    </div>
                                    <h5 class="fw-medium text-dark">Data Tidak Ditemukan</h5>
                                    <p class="text-muted">Tidak ada permohonan yang sesuai dengan filter Anda.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1 + (15 * ($pager->getCurrentPage() - 1)); ?>
                            <?php foreach ($requests as $req): ?>
                                <tr>
                                    <td class="ps-4 text-muted fw-medium py-3"><?= $no++ ?></td>
                                    <td>
                                        <span class="fw-bold" style="color: #1A237E;"><?= esc($req['ticket_number']) ?></span>
                                    </td>
                                    <td>
                                        <div class="text-dark fw-medium"><?= date('d M Y', strtotime($req['created_at'])) ?></div>
                                        <div class="small text-muted"><?= date('H:i', strtotime($req['created_at'])) ?></div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold me-3 shadow-sm" style="width: 40px; height: 40px; font-size: 1rem; background: linear-gradient(135deg, #1A237E, #283593);">
                                                <?= substr(esc($req['applicant_name']), 0, 1) ?>
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark"><?= esc($req['applicant_name']) ?></div>
                                                <div class="small text-muted"><i class="bi bi-envelope me-1"></i><?= esc($req['applicant_email']) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-truncate text-muted" style="max-width: 250px;" title="<?= esc($req['subject']) ?>">
                                            <?= esc($req['subject']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php 
                                        $badgeClass = 'bg-secondary';
                                        $statusText = 'Tidak Diketahui';
                                        if ($req['status'] == 'pending') { $badgeClass = 'badge-soft-warning'; $statusText = 'Menunggu'; }
                                        elseif ($req['status'] == 'process') { $badgeClass = 'badge-soft-info'; $statusText = 'Diproses'; }
                                        elseif ($req['status'] == 'approved') { $badgeClass = 'badge-soft-success'; $statusText = 'Disetujui'; }
                                        elseif ($req['status'] == 'rejected') { $badgeClass = 'badge-soft-danger'; $statusText = 'Ditolak'; }
                                        ?>
                                        <span class="badge <?= $badgeClass ?> px-3 py-2 rounded-pill"><?= $statusText ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if ($pager->getPageCount() > 1): ?>
                <div class="p-4 d-flex justify-content-center border-top">
                    <?= $pager->links('default', 'bootstrap_pagination') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
