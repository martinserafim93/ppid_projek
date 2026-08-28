<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- Greeting Section -->
<div class="greeting-section">
    <h2><?= esc($greeting) ?>, <?= esc($user_name) ?>! 👋</h2>
    <p class="text-muted">Berikut ringkasan data sistem PPID Kalimantan Utara</p>
</div>

<!-- Stat Cards Grid -->
<div class="row g-4 mb-4">
    
    <!-- Card 1: Total Halaman -->
    <div class="col-12 col-md-6 col-xl-3">
        <div class="stat-card stat-card-blue">
            <div class="stat-card-content">
                <div class="stat-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <h3><?= formatNumber($totalPages) ?></h3>
                <p>Total Halaman</p>
            </div>
        </div>
    </div>
    
    <!-- Card 2: Total Regulasi -->
    <div class="col-12 col-md-6 col-xl-3">
        <div class="stat-card stat-card-green">
            <div class="stat-card-content">
                <div class="stat-icon">
                    <i class="bi bi-journal-text"></i>
                </div>
                <h3><?= formatNumber($totalRegulations) ?></h3>
                <p>Total Regulasi</p>
            </div>
        </div>
    </div>
    
    <!-- Card 3: Total Informasi Publik -->
    <div class="col-12 col-md-6 col-xl-3">
        <div class="stat-card stat-card-orange">
            <div class="stat-card-content">
                <div class="stat-icon">
                    <i class="bi bi-folder"></i>
                </div>
                <h3><?= formatNumber($totalInformations) ?></h3>
                <p>Informasi Publik</p>
            </div>
        </div>
    </div>
    
    <!-- Card 4: Total Infografis -->
    <div class="col-12 col-md-6 col-xl-3">
        <div class="stat-card stat-card-purple">
            <div class="stat-card-content">
                <div class="stat-icon">
                    <i class="bi bi-images"></i>
                </div>
                <h3><?= formatNumber($totalInfographics) ?></h3>
                <p>Total Infografis</p>
            </div>
        </div>
    </div>
    
</div>

<!-- Recent Activity Section (Placeholder) -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Aktivitas Terbaru</h5>
            </div>
            <div class="card-body text-center text-muted py-5">
                <i class="bi bi-clock-history" style="font-size: 3rem; opacity: 0.5;"></i>
                <p class="mt-3 mb-0">Fitur aktivitas terbaru akan segera hadir</p>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
