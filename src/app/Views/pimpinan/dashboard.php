<?= $this->extend('layouts/pimpinan') ?>

<?= $this->section('content') ?>
<style>
    /* Dashboard specific styles */
    .stat-icon {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        font-size: 1.75rem;
    }
    .icon-primary { background: rgba(26, 35, 126, 0.1); color: #1A237E; }
    .icon-warning { background: rgba(255, 193, 7, 0.15); color: #b28904; }
    .icon-success { background: rgba(25, 135, 84, 0.1); color: #198754; }
    .icon-danger { background: rgba(220, 53, 69, 0.1); color: #dc3545; }
    
    .badge-soft-warning { background-color: rgba(255, 193, 7, 0.2); color: #997404; }
    .badge-soft-info { background-color: rgba(13, 202, 240, 0.2); color: #087f98; }
    .badge-soft-success { background-color: rgba(25, 135, 84, 0.2); color: #0f5132; }
    .badge-soft-danger { background-color: rgba(220, 53, 69, 0.2); color: #842029; }
    
    .table-hover tbody tr { transition: background-color 0.2s; }
    .table-hover tbody tr:hover { background-color: #f8f9fa; }
</style>

<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1A237E;">Dashboard Eksekutif</h4>
            <p class="text-muted mb-0">Ringkasan performa layanan informasi publik</p>
        </div>
        <div>
            <span class="text-muted small">Periode: <?= date('Y') ?></span>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="stat-icon icon-primary">
                            <i class="bi bi-folder2-open"></i>
                        </div>
                    </div>
                    <h6 class="text-muted mb-1 fw-medium">Total Permohonan</h6>
                    <h2 class="mb-0 fw-bold" style="color: #333;"><?= esc($totalRequests) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="stat-icon icon-warning">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>
                    <h6 class="text-muted mb-1 fw-medium">Menunggu (Pending)</h6>
                    <h2 class="mb-0 fw-bold" style="color: #333;"><?= esc($pendingRequests) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="stat-icon icon-success">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                    <h6 class="text-muted mb-1 fw-medium">Disetujui</h6>
                    <h2 class="mb-0 fw-bold" style="color: #333;"><?= esc($approvedRequests) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="stat-icon icon-danger">
                            <i class="bi bi-x-circle"></i>
                        </div>
                    </div>
                    <h6 class="text-muted mb-1 fw-medium">Ditolak</h6>
                    <h2 class="mb-0 fw-bold" style="color: #333;"><?= esc($rejectedRequests) ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Monthly Chart -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="card-title fw-bold mb-0">Statistik Bulanan</h6>
                </div>
                <div class="card-body px-4 pb-4 pt-3">
                    <canvas id="monthlyChart" height="100"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Extra Stats & Status Chart -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body p-4">
                    <h6 class="card-title fw-bold mb-4">Distribusi Status</h6>
                    <div style="height: 180px; display: flex; justify-content: center;">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="card" style="background: linear-gradient(135deg, #1A237E, #283593); color: white;">
                <div class="card-body p-4 text-center">
                    <div class="row">
                        <div class="col-6 border-end border-light border-opacity-25">
                            <h6 class="mb-2 fw-medium opacity-75" style="font-size: 0.85rem;">Rata-rata Respon</h6>
                            <h4 class="fw-bold mb-0"><?= esc($avgResponseTime) ?></h4>
                        </div>
                        <div class="col-6">
                            <h6 class="mb-2 fw-medium opacity-75" style="font-size: 0.85rem;">Indeks Kepuasan</h6>
                            <div class="text-warning mb-1" style="font-size: 1.1rem;">
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
                            <h5 class="fw-bold mb-0"><?= number_format($rating, 1) ?> <span class="opacity-75" style="font-size: 0.8rem;">/ 5.0</span></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Requests -->
    <div class="card">
        <div class="card-header bg-transparent border-0 p-4 d-flex justify-content-between align-items-center">
            <h6 class="card-title fw-bold mb-0">Permohonan Terbaru</h6>
            <a href="<?= base_url('pimpinan/monitoring') ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 border-top-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 border-0 rounded-start">No. Tiket</th>
                            <th class="border-0">Tanggal</th>
                            <th class="border-0">Pemohon</th>
                            <th class="border-0">Subjek</th>
                            <th class="border-0 rounded-end">Status</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php if(empty($recentRequests)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada permohonan yang diajukan.</td>
                        </tr>
                        <?php else: ?>
                            <?php foreach($recentRequests as $req): ?>
                            <tr>
                                <td class="ps-4 py-3">
                                    <span class="fw-medium" style="color: #1A237E;"><?= esc($req['ticket_number']) ?></span>
                                </td>
                                <td>
                                    <span class="text-muted small"><?= date('d M Y', strtotime($req['created_at'])) ?></span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-primary fw-bold me-2" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                            <?= substr(esc($req['applicant_name']), 0, 1) ?>
                                        </div>
                                        <span class="fw-medium text-dark"><?= esc($req['applicant_name']) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-truncate text-muted" style="max-width: 250px;">
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
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Line Chart (Monthly)
    const ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
    
    // Create gradient for line chart
    let gradient = ctxMonthly.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(26, 35, 126, 0.4)');
    gradient.addColorStop(1, 'rgba(26, 35, 126, 0.0)');

    new Chart(ctxMonthly, {
        type: 'line',
        data: {
            labels: <?= json_encode($monthlyData['labels']) ?>,
            datasets: [{
                label: 'Permohonan',
                data: <?= json_encode($monthlyData['data']) ?>,
                borderColor: '#1A237E',
                backgroundColor: gradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4, // Smooth curve
                pointBackgroundColor: '#fff',
                pointBorderColor: '#1A237E',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1A237E',
                    padding: 12,
                    titleFont: { size: 13, family: 'Inter' },
                    bodyFont: { size: 14, family: 'Inter' },
                    displayColors: false,
                    cornerRadius: 8
                }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    ticks: { stepSize: 1, color: '#999' },
                    grid: { borderDash: [4, 4], color: '#f0f0f0', drawBorder: false }
                },
                x: {
                    ticks: { color: '#999' },
                    grid: { display: false, drawBorder: false }
                }
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
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    position: 'right',
                    labels: {
                        usePointStyle: true,
                        padding: 15,
                        font: { family: 'Inter', size: 12 }
                    }
                },
                tooltip: {
                    backgroundColor: '#333',
                    cornerRadius: 8,
                    padding: 10
                }
            },
            cutout: '75%'
        }
    });
});
</script>
<?= $this->endSection() ?>
