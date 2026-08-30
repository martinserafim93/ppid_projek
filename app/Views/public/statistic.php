<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<section class="py-5" style="background-color: var(--bg-light); min-height: 70vh;">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary fw-bold text-uppercase" style="letter-spacing: 2px;">Data</h6>
            <h2 class="heading-font fw-bold"><?= esc($title) ?></h2>
            <p class="text-muted max-w-700 mx-auto mt-3">Transparansi layanan informasi publik PPID Kanwil Kemenag Kaltara.</p>
        </div>

        <div class="row g-4">
            <!-- Chart Section -->
            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                <div class="card-glass border-0 overflow-hidden h-100">
                    <div class="p-4 bg-white border-bottom">
                        <h5 class="fw-bold mb-0">Tren Permohonan Informasi</h5>
                    </div>
                    <div class="p-4 bg-white h-100">
                        <canvas id="yearlyChart" height="120"></canvas>
                    </div>
                </div>
            </div>

            <!-- Download Laporan Section -->
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card-glass border-0 overflow-hidden h-100">
                    <div class="p-4 bg-white border-bottom">
                        <h5 class="fw-bold mb-0">Laporan Tahunan</h5>
                    </div>
                    <div class="p-4 bg-white h-100">
                        <?php if (empty($reports)): ?>
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-folder-x fs-2 d-block mb-2"></i>
                                Belum ada laporan tersedia.
                            </div>
                        <?php else: ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($reports as $report): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                                        <div>
                                            <h6 class="mb-1 fw-bold"><?= esc($report['title']) ?></h6>
                                            <small class="text-muted"><?= date('M Y', strtotime($report['created_at'])) ?></small>
                                        </div>
                                        <a href="<?= base_url('dokumen/download/' . $report['id']) ?>" target="_blank" class="btn btn-sm btn-outline-primary-custom" title="Unduh">
                                            <i class="bi bi-download"></i>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Tabel Rekap Section -->
            <div class="col-12" data-aos="fade-up" data-aos-delay="300">
                <div class="card-glass border-0 overflow-hidden">
                    <div class="p-4 bg-white border-bottom">
                        <h5 class="fw-bold mb-0">Rekapitulasi Status Permohonan</h5>
                    </div>
                    <div class="table-responsive bg-white">
                        <table class="table table-hover table-custom mb-0 text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="20%">Tahun</th>
                                    <th width="20%">Disetujui / Diterima</th>
                                    <th width="20%">Ditolak</th>
                                    <th width="20%">Dalam Proses</th>
                                    <th width="20%">Total Permohonan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($yearlyStats)): ?>
                                    <tr>
                                        <td colspan="5" class="py-5 text-muted">Belum ada data permohonan.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($yearlyStats as $stat): ?>
                                        <tr>
                                            <td class="fw-bold"><?= esc($stat['year']) ?></td>
                                            <td class="text-success fw-medium"><?= esc($stat['approved']) ?></td>
                                            <td class="text-danger fw-medium"><?= esc($stat['rejected']) ?></td>
                                            <td class="text-warning text-dark fw-medium"><?= esc($stat['in_process']) ?></td>
                                            <td class="fw-bold bg-light"><?= esc($stat['total']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('yearlyChart').getContext('2d');
    
    // Gradient fill
    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(27, 94, 32, 0.2)');
    gradient.addColorStop(1, 'rgba(27, 94, 32, 0)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($chartLabels) ?>,
            datasets: [{
                label: 'Jumlah Permohonan',
                data: <?= json_encode($chartData) ?>,
                backgroundColor: '#1B5E20',
                borderRadius: 4,
                barThickness: 40
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    ticks: { stepSize: 1 } 
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
});
</script>
<?= $this->endSection() ?>
