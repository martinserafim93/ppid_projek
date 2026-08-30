<?= $this->extend('layouts/pimpinan') ?>

<?= $this->section('content') ?>
<div class="container-fluid p-0">
    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Total Permohonan</h6>
                            <h2 class="mb-0 mt-2 fw-bold"><?= esc($totalRequests) ?></h2>
                        </div>
                        <i class="bi bi-folder2-open fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Menunggu (Pending)</h6>
                            <h2 class="mb-0 mt-2 fw-bold"><?= esc($pendingRequests) ?></h2>
                        </div>
                        <i class="bi bi-hourglass-split fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Disetujui</h6>
                            <h2 class="mb-0 mt-2 fw-bold"><?= esc($approvedRequests) ?></h2>
                        </div>
                        <i class="bi bi-check-circle fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Ditolak</h6>
                            <h2 class="mb-0 mt-2 fw-bold"><?= esc($rejectedRequests) ?></h2>
                        </div>
                        <i class="bi bi-x-circle fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Monthly Chart -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="card-title fw-bold">Statistik Permohonan (<?= date('Y') ?>)</h5>
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" height="100"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Status Chart & Extra Stats -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h5 class="card-title fw-bold">Status Permohonan</h5>
                </div>
                <div class="card-body text-center">
                    <div style="height: 200px; display: flex; justify-content: center;">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body text-center">
                    <h6 class="text-muted mb-2">Rata-rata Waktu Penyelesaian</h6>
                    <h3 class="fw-bold text-primary mb-3"><?= esc($avgResponseTime) ?></h3>
                    
                    <h6 class="text-muted mb-2">Indeks Kepuasan (Survei)</h6>
                    <div class="text-warning fs-3 mb-1">
                        <?php 
                        $rating = (float)$avgRating;
                        for($i=1; $i<=5; $i++): 
                            if($rating >= $i): echo '<i class="bi bi-star-fill"></i>';
                            elseif($rating >= $i - 0.5): echo '<i class="bi bi-star-half"></i>';
                            else: echo '<i class="bi bi-star"></i>';
                            endif;
                        endfor;
                        ?>
                    </div>
                    <h5 class="fw-bold"><?= number_format($rating, 1) ?> / 5.0</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Requests -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-4 pb-2 d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold mb-0">Permohonan Terbaru</h5>
            <a href="<?= base_url('pimpinan/monitoring') ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No. Tiket</th>
                            <th>Tanggal</th>
                            <th>Pemohon</th>
                            <th>Subjek</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($recentRequests)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada data permohonan.</td>
                        </tr>
                        <?php else: ?>
                            <?php foreach($recentRequests as $req): ?>
                            <tr>
                                <td class="ps-4"><span class="badge bg-light text-dark border"><?= esc($req['ticket_number']) ?></span></td>
                                <td><?= date('d/m/Y', strtotime($req['created_at'])) ?></td>
                                <td><?= esc($req['applicant_name']) ?></td>
                                <td>
                                    <div class="text-truncate" style="max-width: 250px;">
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
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Line Chart (Monthly)
    const ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
    new Chart(ctxMonthly, {
        type: 'line',
        data: {
            labels: <?= json_encode($monthlyData['labels']) ?>,
            datasets: [{
                label: 'Jumlah Permohonan',
                data: <?= json_encode($monthlyData['data']) ?>,
                borderColor: '#1A237E',
                backgroundColor: 'rgba(26, 35, 126, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: '#1A237E',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // Doughnut Chart (Status)
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Menunggu', 'Diproses', 'Disetujui', 'Ditolak'],
            datasets: [{
                data: [
                    <?= $statusData['pending'] ?>,
                    <?= $statusData['process'] ?>,
                    <?= $statusData['approved'] ?>,
                    <?= $statusData['rejected'] ?>
                ],
                backgroundColor: ['#ffc107', '#0dcaf0', '#198754', '#dc3545'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            },
            cutout: '70%'
        }
    });
});
</script>
<?= $this->endSection() ?>
