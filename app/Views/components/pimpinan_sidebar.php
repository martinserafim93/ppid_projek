<aside class="sidebar" id="sidebar">
    <!-- Logo Section -->
    <div class="sidebar-logo">
        <img src="<?= base_url(getSetting('site_logo') ?: 'assets/img/kemenag-new-2025.png') ?>" alt="Logo Kemenag">
        <h5>PPID KALTARA<br><small style="font-size: 0.7em;">Pimpinan</small></h5>
    </div>

    <!-- Navigation Menu -->
    <nav class="nav flex-column">
        <a href="<?= base_url('pimpinan/dashboard') ?>" class="nav-link <?= isActiveMenu('pimpinan/dashboard') ?>">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>

        <a href="<?= base_url('pimpinan/monitoring') ?>" class="nav-link <?= isActiveMenu('pimpinan/monitoring') ?>">
            <i class="bi bi-envelope-paper"></i>
            <span>Monitoring Permohonan</span>
        </a>
        
        <a href="<?= base_url('pimpinan/laporan') ?>" class="nav-link <?= isActiveMenu('pimpinan/laporan') ?>">
            <i class="bi bi-bar-chart-line"></i>
            <span>Laporan Statistik</span>
        </a>
        
        <a href="<?= base_url('pimpinan/survei') ?>" class="nav-link <?= isActiveMenu('pimpinan/survei') ?>">
            <i class="bi bi-star"></i>
            <span>Hasil Survei</span>
        </a>
    </nav>

    <!-- Logout Button -->
    <div class="sidebar-footer">
        <a href="<?= base_url('auth/logout') ?>" class="btn-logout" style="color: #fff; border-color: rgba(255,255,255,0.2);">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>
    </div>
</aside>
