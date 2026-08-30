<?= $this->extend('layouts/pimpinan') ?>

<?= $this->section('content') ?>
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Laporan Statistik Permohonan</h4>
        <a href="<?= base_url('pimpinan/laporan/export') ?>" class="btn btn-success shadow-sm">
            <i class="bi bi-file-earmark-spreadsheet me-2"></i> Unduh Rekap Data (CSV)
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title fw-bold mb-4">Ringkasan Status Permohonan</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Status Permohonan</th>
                            <th class="text-center">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = 0;
                        if(empty($statusCounts)): ?>
                            <tr><td colspan="2" class="text-center">Belum ada data permohonan.</td></tr>
                        <?php else: ?>
                            <?php foreach($statusCounts as $row): 
                                $total += $row['total'];
                                $badgeClass = 'bg-secondary';
                                if($row['status'] == 'pending') $badgeClass = 'bg-warning text-dark';
                                if($row['status'] == 'process') $badgeClass = 'bg-info text-dark';
                                if($row['status'] == 'approved') $badgeClass = 'bg-success';
                                if($row['status'] == 'rejected') $badgeClass = 'bg-danger';
                                if($row['status'] == 'objection') $badgeClass = 'bg-dark';
                            ?>
                            <tr>
                                <td>
                                    <span class="badge <?= $badgeClass ?> text-uppercase"><?= $row['status'] ?></span>
                                </td>
                                <td class="text-center fw-bold"><?= $row['total'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <tr class="table-light fw-bold">
                                <td>TOTAL KESELURUHAN</td>
                                <td class="text-center"><?= $total ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
