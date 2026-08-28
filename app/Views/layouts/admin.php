<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard Admin - PPID Kalimantan Utara">
    <title><?= esc($title ?? 'Dashboard') ?> - PPID Kaltara</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <!-- Custom Admin CSS -->
    <link href="<?= base_url('assets/css/admin.css') ?>" rel="stylesheet">
</head>
<body>
    
    <!-- Sidebar -->
    <?= $this->include('components/admin_sidebar') ?>
    
    <!-- Backdrop for Mobile -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
    
    <!-- Main Content -->
    <main class="main-content">
        
        <!-- Header -->
        <?= $this->include('components/admin_header') ?>
        
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <?= $this->renderSection('content') ?>
        </div>
        
        <!-- Footer -->
        <footer>
            <p class="mb-0">&copy; <?= date('Y') ?> PPID Kanwil Kemenag Kaltara - Tim Humas dan Komunikasi Publik (Sekretariat Jenderal)</p>
        </footer>
        
    </main>
    
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (required for Summernote) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom Admin JS -->
    <script src="<?= base_url('assets/js/admin.js') ?>"></script>
    
    <!-- Admin Utilities JS -->
    <script src="<?= base_url('assets/js/admin/delete-confirm.js') ?>"></script>
    <script src="<?= base_url('assets/js/admin/form-validation.js') ?>"></script>
    <script src="<?= base_url('assets/js/admin/image-preview.js') ?>"></script>
    
    <!-- Custom Scripts for specific views -->
    <?= $this->renderSection('scripts') ?>
    
</body>
</html>
