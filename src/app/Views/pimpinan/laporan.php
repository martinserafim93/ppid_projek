<?= $this->extend('layouts/pimpinan') ?>

<?= $this->section('content') ?>
<style>
    .status-card {
        border-radius: 16px;
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .status-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }
    .progress-bar-custom {
        height: 12px;
        border-radius: 6px;
    }
    
    .bg-gradient-warning { background: linear-gradient(135deg, #FFC107, #FF9800); }
    .bg-gradient-info { background: linear-gradient(135deg, #0DCAF0, #00BCD4); }
    .bg-gradient-success { background: linear-gradient(135deg, #198754, #4CAF50); }
    .bg-gradient-danger { background: linear-gradient(135deg, #DC3545, #F44336); }
    .bg-gradient-dark { background: linear-gradient(135deg, #212529, #424242); }
</style>

<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1A237E;">Laporan Statistik Permohonan</h4>
            <p class="text-muted mb-0">Visualisasi data dan rekapitulasi jumlah permohonan informasi</p>
        </div>
        <div>
            <a href="<?= base_url('pimpinan/laporan/export') ?>" class="btn btn-success rounded-pill px-4 shadow-sm" style="background-color: #1B5E20; border: none;">
                <i class="bi bi-file-earmark-spreadsheet me-2"></i> Unduh Laporan (CSV)
            </a>
        </div>
    </div>

    <?php 
        $total = 0;
        $stats = [
            'pending' => ['count' => 0, 'label' => 'Menunggu', 'color' => 'warning', 'icon' => 'bi-hourglass-split'],
            'process' => ['count' => 0, 'label' => 'Diproses', 'color' => 'info', 'icon' => 'bi-arrow-repeat'],
            'approved' => ['count' => 0, 'label' => 'Disetujui', 'color' => 'success', 'icon' => 'bi-check-circle'],
            'rejected' => ['count' => 0, 'label' => 'Ditolak', 'color' => 'danger', 'icon' => 'bi-x-circle'],
            'objection' => ['count' => 0, 'label' => 'Keberatan', 'color' => 'dark', 'icon' => 'bi-shield-exclamation']
        ];
        
        if (!empty($statusCounts)) {
            foreach ($statusCounts as $row) {
                $total += $row['total'];
                if (isset($stats[$row['status']])) {
                    $stats[$row['status']]['count'] = $row['total'];
                }
            }
        }
    ?>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-white h-100">
                <div class="card-body p-5">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center text-md-start mb-4 mb-md-0 border-end-md">
                            <h6 class="text-muted text-uppercase fw-semibold letter-spacing-1 mb-2">Total Keseluruhan</h6>
                            <h1 class="display-3 fw-bold text-dark mb-0"><?= $total ?></h1>
                            <p class="text-muted">Permohonan terdaftar di sistem</p>
                        </div>
                        <div class="col-md-8 ps-md-5">
                            <div class="d-flex flex-column gap-3">
                                <?php foreach ($stats as $key => $stat): ?>
                                    <?php 
                                        $percentage = ($total > 0) ? round(($stat['count'] / $total) * 100, 1) : 0; 
                                    ?>
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex align-items-center" style="width: 140px;">
                                            <div class="rounded-circle bg-<?= $stat['color'] ?> bg-opacity-10 text-<?= $stat['color'] ?> d-flex justify-content-center align-items-center me-3" style="width: 32px; height: 32px;">
                                                <i class="bi <?= $stat['icon'] ?>"></i>
                                            </div>
                                            <span class="fw-medium text-dark"><?= $stat['label'] ?></span>
                                        </div>
                                        <div class="flex-grow-1 mx-3">
                                            <div class="progress progress-bar-custom bg-light">
                                                <div class="progress-bar bg-gradient-<?= $stat['color'] ?>" role="progressbar" style="width: <?= $percentage ?>%;" aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="text-end" style="width: 100px;">
                                            <span class="fw-bold fs-5"><?= $stat['count'] ?></span>
                                            <span class="text-muted small"> (<?= $percentage ?>%)</span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
