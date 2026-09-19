<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard Pimpinan - PPID Kalimantan Utara">
    <title><?= esc($title ?? 'Dashboard Pimpinan') ?> - PPID Kaltara</title>
    
    <?php $favicon = getSetting('site_favicon') ?: 'assets/img/kemenag-new-2025.png'; ?>
    <link rel="icon" href="<?= base_url($favicon) ?>">
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/swal-premium.css') ?>" rel="stylesheet">
    
    <!-- Custom Admin CSS -->
    <link href="<?= base_url('assets/css/admin.css') ?>" rel="stylesheet">
    
    <!-- Pimpinan Custom Style Overrides -->
    <style>
        :root {
            --primary-color: #1A237E;
            --primary-hover: #283593;
            --sidebar-bg: linear-gradient(180deg, #1A237E 0%, #0d1240 100%);
            --accent-color: #C9A84C;
        }
        body { background-color: #f4f6f9; font-family: 'Inter', sans-serif; }
        .sidebar { background: var(--sidebar-bg); }
        .sidebar-logo { border-bottom: 1px solid rgba(255,255,255,0.05); }
        .sidebar .nav-link { transition: all 0.3s ease; border-left: 3px solid transparent; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.08);
            transform: translateX(4px);
            border-left: 3px solid var(--accent-color);
        }
        .sidebar .nav-link.active { font-weight: 600; }
        .main-header { 
            background: rgba(255, 255, 255, 0.85); 
            backdrop-filter: blur(12px); 
            border-bottom: 1px solid rgba(0,0,0,0.03);
            box-shadow: 0 4px 20px rgba(0,0,0,0.015);
        }
        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); }
        .btn-primary:hover { background-color: var(--primary-hover); border-color: var(--primary-hover); }
        .text-primary { color: var(--primary-color) !important; }
        .bg-primary { background-color: var(--primary-color) !important; }
        .card { border-radius: 16px; border: none; box-shadow: 0 4px 24px rgba(0,0,0,0.04); transition: transform 0.2s, box-shadow 0.2s; }
        .card:hover { box-shadow: 0 8px 32px rgba(0,0,0,0.08); }
        .table-light th { background-color: #f8f9fa; font-weight: 600; color: #555; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; }
        .badge { font-weight: 500; padding: 0.4em 0.8em; border-radius: 6px; }
    </style>
</head>
<body>
    
    <!-- Sidebar -->
    <?= $this->include('components/pimpinan_sidebar') ?>
    
    <!-- Backdrop for Mobile -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
    
    <!-- Main Content -->
    <main class="main-content">
        
        <!-- Header -->
        <header class="main-header">
            <div class="header-left">
                <!-- Toggle Button for Mobile -->
                <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
                    <i class="bi bi-list"></i>
                </button>
                
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('pimpinan/dashboard') ?>">Pimpinan</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= esc($title ?? 'Dashboard') ?></li>
                    </ol>
                </nav>
            </div>
            
            <div class="header-right">
                <!-- User Menu -->
                <div class="user-menu">
                    <div class="user-info" id="userMenuToggle">
                        <div class="user-avatar" style="<?php echo session()->get('user_avatar') ? 'padding: 0; overflow: hidden; background: transparent;' : 'background-color: #1A237E; color: white;'; ?>">
                            <?php if (session()->get('user_avatar')) : ?>
                                <img src="<?= base_url('uploads/avatars/' . session()->get('user_avatar')) ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else : ?>
                                <?= substr(esc(session()->get('user_name') ?? 'P'), 0, 1) ?>
                            <?php endif; ?>
                        </div>
                        <div class="user-details">
                            <span class="user-name"><?= esc(session()->get('user_name') ?? 'Pimpinan') ?></span>
                            <span class="user-role">Pimpinan</span>
                        </div>
                        <i class="bi bi-chevron-down user-dropdown-icon"></i>
                    </div>
                    
                    <!-- Dropdown Menu -->
                    <div class="user-dropdown" id="userDropdown">
                        <a href="<?= base_url('pimpinan/profile') ?>">
                            <i class="bi bi-person"></i>
                            <span>Profile</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url('auth/logout') ?>">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <?= $this->renderSection('content') ?>
        </div>
        
        <!-- Footer -->
        <footer>
            <p class="mb-0">&copy; <?= date('Y') ?> PPID Kanwil Kemenag Kaltara - Panel Pimpinan</p>
        </footer>
        
    </main>
    
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (required for ChartJS potentially, though ChartJS doesn't need it, just to match layout) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom Admin JS -->
    <script src="<?= base_url('assets/js/admin.js') ?>"></script>
    
    <!-- Logout Confirm JS -->
    <script src="<?= base_url('assets/js/logout-confirm.js') ?>"></script>
    
    <!-- Custom Scripts for specific views -->
    <?= $this->renderSection('scripts') ?>
    
</body>
</html>
