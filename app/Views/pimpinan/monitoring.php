<?= $this->extend('layouts/pimpinan') ?>

<?= $this->section('content') ?>
<div class="container-fluid p-0">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-4 pb-2 d-flex flex-wrap justify-content-between align-items-center">
            <h5 class="card-title fw-bold mb-3 mb-md-0">Monitoring Permohonan Informasi</h5>
            
            <form action="<?= current_url() ?>" method="GET" class="d-flex gap-2">
                <select name="status" class="form-select form-select-sm" style="width: auto;">
                    <option value="">Semua Status</option>
                    <option value="pending" <?= ($status == 'pending') ? 'selected' : '' ?>>Menunggu</option>
                    <option value="process" <?= ($status == 'process') ? 'selected' : '' ?>>Diproses</option>
                    <option value="approved" <?= ($status == 'approved') ? 'selected' : '' ?>>Disetujui</option>
                    <option value="rejected" <?= ($status == 'rejected') ? 'selected' : '' ?>>Ditolak</option>
                </select>
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" name="search" class="form-control" placeholder="Cari tiket, nama, subjek..." value="<?= esc($search ?? '') ?>">
                    <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                </div>
                <?php if(!empty($search) || !empty($status)): ?>
                    <a href="<?= current_url() ?>" class="btn btn-sm btn-light"><i class="bi bi-x"></i></a>
                <?php endif; ?>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" width="5%">No</th>
                            <th width="15%">No. Tiket</th>
                            <th width="15%">Tanggal</th>
                            <th width="20%">Pemohon</th>
                            <th width="30%">Subjek Informasi</th>
                            <th width="15%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($requests)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Data permohonan tidak ditemukan.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1 + (15 * ($pager->getCurrentPage() - 1)); ?>
                            <?php foreach ($requests as $req): ?>
                                <tr>
                                    <td class="ps-4 text-muted"><?= $no++ ?></td>
                                    <td>
                                        <span class="badge bg-light text-dark border"><?= esc($req['ticket_number']) ?></span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($req['created_at'])) ?></td>
                                    <td>
                                        <div class="fw-medium text-dark"><?= esc($req['applicant_name']) ?></div>
                                        <div class="small text-muted"><?= esc($req['applicant_email']) ?></div>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 300px;" title="<?= esc($req['subject']) ?>">
                                            <?= esc($req['subject']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php 
                                        $badgeClass = 'bg-secondary';
                                        $statusText = 'Tidak Diketahui';
                                        if ($req['status'] == 'pending') { $badgeClass = 'bg-warning text-dark'; $statusText = 'Menunggu'; }
                                        elseif ($req['status'] == 'process') { $badgeClass = 'bg-info text-dark'; $statusText = 'Diproses'; }
                                        elseif ($req['status'] == 'approved') { $badgeClass = 'bg-success'; $statusText = 'Disetujui'; }
                                        elseif ($req['status'] == 'rejected') { $badgeClass = 'bg-danger'; $statusText = 'Ditolak'; }
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= $statusText ?></span>
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
