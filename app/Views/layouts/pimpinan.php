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
    
    <!-- Custom Admin CSS -->
    <link href="<?= base_url('assets/css/admin.css') ?>" rel="stylesheet">
    
    <!-- Pimpinan Custom Style Overrides -->
    <style>
        :root {
            --primary-color: #1A237E;
            --primary-hover: #283593;
            --sidebar-bg: #1A237E;
        }
        .sidebar { background-color: var(--sidebar-bg); }
        .sidebar-logo { border-bottom-color: rgba(255,255,255,0.1); }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.1);
        }
        .main-header { border-bottom: 2px solid #e0e0e0; }
        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); }
        .btn-primary:hover { background-color: var(--primary-hover); border-color: var(--primary-hover); }
        .text-primary { color: var(--primary-color) !important; }
        .bg-primary { background-color: var(--primary-color) !important; }
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
                        <div class="user-avatar" style="background-color: #1A237E; color: white;">
                            P
                        </div>
                        <div class="user-details">
                            <span class="user-name"><?= esc(session()->get('user_name') ?? 'Pimpinan') ?></span>
                            <span class="user-role">Pimpinan</span>
                        </div>
                        <i class="bi bi-chevron-down user-dropdown-icon"></i>
                    </div>
                    
                    <!-- Dropdown Menu -->
                    <div class="user-dropdown" id="userDropdown">
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
    
    <!-- Custom Admin JS -->
    <script src="<?= base_url('assets/js/admin.js') ?>"></script>
    
    <!-- Custom Scripts for specific views -->
    <?= $this->renderSection('scripts') ?>
    
</body>
</html>
