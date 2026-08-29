<?php
// Mendapatkan segment URI untuk penanda menu aktif
$uri = service('uri');
$segment1 = $uri->getTotalSegments() >= 1 ? $uri->getSegment(1) : '';
$segment2 = $uri->getTotalSegments() >= 2 ? $uri->getSegment(2) : '';

// Mengambil menu dinamis dari database
$pageModel = new \App\Models\PageModel();
$activePages = $pageModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();

$menuProfil = array_filter($activePages, fn($p) => in_array($p['category'], ['profil_kanwil', 'profil_ppid']));
$menuLayanan = array_filter($activePages, fn($p) => $p['category'] === 'standar_layanan');
$menuInformasi = array_filter($activePages, fn($p) => $p['category'] === 'layanan_informasi');
?>
<nav class="navbar navbar-expand-lg navbar-dark navbar-ppid sticky-top">
    <div class="container">
        <!-- Tampil di mobile jika topbar hidden -->
        <a class="navbar-brand d-lg-none d-flex align-items-center" href="<?= base_url() ?>">
            <img src="<?= base_url('assets/img/kemenag-new-2025.png') ?>" alt="Logo Kemenag" class="me-2" style="height: 40px;">
            <span class="heading-font fw-bold text-white lh-sm" style="font-size: 14px; white-space: normal; line-height: 1.2;">
                PPID Kantor Wilayah Kementerian Agama Provinsi Kalimantan Utara
            </span>
        </a>
        
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1">
                <li class="nav-item">
                    <a class="nav-link <?= $segment1 == '' ? 'active' : '' ?>" href="<?= base_url() ?>">Beranda</a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= $segment1 == 'profil' ? 'active' : '' ?>" href="#" id="navbarProfil" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Profil
                    </a>
                    <ul class="dropdown-menu shadow-lg border-0" aria-labelledby="navbarProfil">
                        <?php foreach ($menuProfil as $page): ?>
                            <li>
                                <a class="dropdown-item <?= $segment2 == $page['slug'] ? 'active text-primary' : '' ?>" 
                                   href="<?= base_url('profil/' . $page['slug']) ?>">
                                    <?= esc($page['title']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?= $segment1 == 'regulasi' ? 'active' : '' ?>" href="<?= base_url('regulasi') ?>">Regulasi</a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= $segment1 == 'layanan' ? 'active' : '' ?>" href="#" id="navbarLayanan" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Standar Layanan
                    </a>
                    <ul class="dropdown-menu shadow-lg border-0" aria-labelledby="navbarLayanan">
                        <?php foreach ($menuLayanan as $page): ?>
                            <li>
                                <a class="dropdown-item <?= $segment2 == $page['slug'] ? 'active text-primary' : '' ?>" 
                                   href="<?= base_url('layanan/' . $page['slug']) ?>">
                                    <?= esc($page['title']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        <li>
                            <a class="dropdown-item <?= ($segment1 == 'dokumen' && $segment2 == 'sop') ? 'active text-primary' : '' ?>"
                               href="<?= base_url('dokumen/sop') ?>">
                                SOP Layanan
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= $segment1 == 'informasi' ? 'active' : '' ?>" href="#" id="navbarInfoLayanan" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Layanan Informasi
                    </a>
                    <ul class="dropdown-menu shadow-lg border-0" aria-labelledby="navbarInfoLayanan">
                        <?php foreach ($menuInformasi as $page): ?>
                            <li>
                                <a class="dropdown-item <?= $segment2 == $page['slug'] ? 'active text-primary' : '' ?>" 
                                   href="<?= base_url('informasi/' . $page['slug']) ?>">
                                    <?= esc($page['title']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?= $segment1 == 'informasi-publik' ? 'active' : '' ?>" href="<?= base_url('informasi-publik') ?>">
                        Informasi Publik
                    </a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= in_array($segment1, ['data', 'infografis']) ? 'active' : '' ?>" href="#" id="navbarData" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Data & Infografis
                    </a>
                    <ul class="dropdown-menu shadow-lg border-0" aria-labelledby="navbarData">
                        <li><a class="dropdown-item <?= $segment1 == 'data' ? 'active text-primary' : '' ?>" href="<?= base_url('data') ?>">Data & Statistik</a></li>
                        <li><a class="dropdown-item <?= $segment1 == 'infografis' ? 'active text-primary' : '' ?>" href="<?= base_url('infografis') ?>">Galeri Infografis</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
