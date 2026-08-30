<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Preconnect & DNS-Prefetch ke origin CDN (percepat DNS/TLS) -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://unpkg.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://unpkg.com">
    <title><?= esc($title ?? 'Beranda') ?> | <?= esc(getSetting('site_name') ?? 'PPID Kanwil Kemenag Kaltara') ?></title>
    
    <!-- Meta SEO & Favicon -->
    <meta name="description" content="<?= esc(getSetting('site_description') ?? 'Portal Resmi Pejabat Pengelola Informasi dan Dokumentasi (PPID) Kanwil Kemenag Kalimantan Utara') ?>">
    <?php $favicon = getSetting('site_favicon') ?: 'assets/img/kemenag-new-2025.png'; ?>
    <link rel="icon" href="<?= base_url($favicon) ?>">

    <!-- Libraries -->
    <!-- Bootstrap 5.3 -->
    <link href="<?= base_url('assets/vendor/bootstrap/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="<?= base_url('assets/vendor/aos/aos.css') ?>" rel="stylesheet">
    <!-- GLightbox (for Image Popups) -->
    <link href="<?= base_url('assets/vendor/glightbox/glightbox.min.css') ?>" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    
    <?= $this->renderSection('styles') ?>
</head>
<body>

    <!-- Topbar -->
    <?= $this->include('components/public_topbar') ?>

    <!-- Navbar -->
    <?= $this->include('components/public_navbar') ?>

    <!-- Breadcrumb (Optional, ditangani per-halaman) -->
    <?= $this->renderSection('breadcrumb') ?>

    <!-- Main Content -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <?= $this->include('components/public_footer') ?>

    <!-- Back to Top Button -->
    <?= $this->include('components/back_to_top') ?>

    <!-- Scripts -->
    <script src="<?= base_url('assets/vendor/jquery/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/aos/aos.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/glightbox/glightbox.min.js') ?>"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });

        // Initialize Lightbox (if any)
        const lightbox = GLightbox({
            selector: '.glightbox'
        });

        // Back to top behavior
        $(window).scroll(function () {
            if ($(this).scrollTop() > 300) {
                $('#back-to-top').addClass('show');
            } else {
                $('#back-to-top').removeClass('show');
            }
        });

        $('#back-to-top').click(function () {
            $('html, body').animate({ scrollTop: 0 }, 500);
            return false;
        });
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
