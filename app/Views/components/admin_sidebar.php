<aside class="sidebar" id="sidebar">
    <!-- Logo Section -->
    <div class="sidebar-logo">
        <img src="<?= base_url('assets/img/kemenag-new-2025.png') ?>" alt="Logo Kemenag">
        <h5>PPID KALTARA</h5>
    </div>

    <!-- Navigation Menu -->
    <nav class="nav flex-column">
        <a href="<?= base_url('admin/dashboard') ?>" class="nav-link <?= isActiveMenu('admin/dashboard') ?>">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>

        <a href="<?= base_url('admin/requests') ?>" class="nav-link <?= isActiveMenu('admin/requests') ?>">
            <i class="bi bi-envelope-paper"></i>
            <span>Kelola Permohonan</span>
        </a>
        
        <a href="<?= base_url('admin/pages') ?>" class="nav-link <?= isActiveMenu('admin/pages') ?>">
            <i class="bi bi-file-earmark-text"></i>
            <span>Kelola Halaman</span>
        </a>
        
        <a href="<?= base_url('admin/regulations') ?>" class="nav-link <?= isActiveMenu('admin/regulations') ?>">
            <i class="bi bi-journal-text"></i>
            <span>Kelola Regulasi</span>
        </a>
        
        <a href="<?= base_url('admin/public-informations') ?>" class="nav-link <?= isActiveMenu('admin/public-informations') ?>">
            <i class="bi bi-folder"></i>
            <span>Kelola Informasi Publik</span>
        </a>
        
        <a href="<?= base_url('admin/infographics') ?>" class="nav-link <?= isActiveMenu('admin/infographics') ?>">
            <i class="bi bi-images"></i>
            <span>Kelola Infografis</span>
        </a>
        
        <a href="<?= base_url('admin/documents') ?>" class="nav-link <?= isActiveMenu('admin/documents') ?>">
            <i class="bi bi-paperclip"></i>
            <span>Kelola Dokumen</span>
        </a>
        
        <a href="<?= base_url('admin/users') ?>" class="nav-link <?= isActiveMenu('admin/users') ?>">
            <i class="bi bi-people"></i>
            <span>Manajemen User</span>
        </a>

        <a href="<?= base_url('admin/pemohon') ?>" class="nav-link <?= isActiveMenu('admin/pemohon') ?>">
            <i class="bi bi-person-vcard"></i>
            <span>Manajemen Pemohon</span>
        </a>
        
        <a href="<?= base_url('admin/settings') ?>" class="nav-link <?= isActiveMenu('admin/settings') ?>">
            <i class="bi bi-gear"></i>
            <span>Pengaturan Situs</span>
        </a>
    </nav>

    <!-- Logout Button -->
    <div class="sidebar-footer">
        <a href="<?= base_url('auth/logout') ?>" class="btn-logout">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>
    </div>
</aside>
