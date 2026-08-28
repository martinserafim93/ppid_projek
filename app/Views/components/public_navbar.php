<?php
// Mendapatkan segment URI untuk penanda menu aktif
$uri = service('uri');
$segment1 = $uri->getTotalSegments() >= 1 ? $uri->getSegment(1) : '';
$segment2 = $uri->getTotalSegments() >= 2 ? $uri->getSegment(2) : '';
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
                        <li><a class="dropdown-item <?= $segment2 == 'sejarah-kanwil' ? 'active text-primary' : '' ?>" href="<?= base_url('profil/sejarah-kanwil') ?>">Sejarah Kanwil</a></li>
                        <li><a class="dropdown-item <?= $segment2 == 'profil-ppid' ? 'active text-primary' : '' ?>" href="<?= base_url('profil/profil-ppid') ?>">Profil PPID</a></li>
                        <li><a class="dropdown-item <?= $segment2 == 'struktur-organisasi' ? 'active text-primary' : '' ?>" href="<?= base_url('profil/struktur-organisasi') ?>">Struktur Organisasi</a></li>
                        <li><a class="dropdown-item <?= $segment2 == 'tugas-dan-fungsi' ? 'active text-primary' : '' ?>" href="<?= base_url('profil/tugas-dan-fungsi') ?>">Tugas dan Fungsi PPID</a></li>
                        <li><a class="dropdown-item <?= $segment2 == 'visi-dan-misi' ? 'active text-primary' : '' ?>" href="<?= base_url('profil/visi-dan-misi') ?>">Visi dan Misi</a></li>
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
                        <li><a class="dropdown-item <?= $segment2 == 'maklumat-pelayanan' ? 'active text-primary' : '' ?>" href="<?= base_url('layanan/maklumat-pelayanan') ?>">Maklumat Pelayanan</a></li>
                        <li><a class="dropdown-item <?= $segment2 == 'pedoman-pengelolaan' ? 'active text-primary' : '' ?>" href="<?= base_url('layanan/pedoman-pengelolaan') ?>">Pedoman Pengelolaan Organisasi</a></li>
                        <li><a class="dropdown-item <?= $segment2 == 'jadwal-layanan' ? 'active text-primary' : '' ?>" href="<?= base_url('layanan/jadwal-layanan') ?>">Jadwal Layanan</a></li>
                        <li><a class="dropdown-item <?= $segment2 == 'biaya-layanan' ? 'active text-primary' : '' ?>" href="<?= base_url('layanan/biaya-layanan') ?>">Biaya/Tarif Layanan</a></li>
                        <li><a class="dropdown-item <?= $segment2 == 'sop-ppid' ? 'active text-primary' : '' ?>" href="<?= base_url('layanan/sop-ppid') ?>">SOP PPID</a></li>
                        <li><a class="dropdown-item <?= $segment2 == 'standar-operasional' ? 'active text-primary' : '' ?>" href="<?= base_url('layanan/standar-operasional') ?>">Standar Operasional (PPEM)</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= $segment1 == 'informasi' ? 'active' : '' ?>" href="#" id="navbarInfoLayanan" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Layanan Informasi
                    </a>
                    <ul class="dropdown-menu shadow-lg border-0" aria-labelledby="navbarInfoLayanan">
                        <li><a class="dropdown-item <?= $segment2 == 'tata-cara-permohonan' ? 'active text-primary' : '' ?>" href="<?= base_url('informasi/tata-cara-permohonan') ?>">Tata Cara Permohonan Info</a></li>
                        <li><a class="dropdown-item <?= $segment2 == 'tata-cara-keberatan' ? 'active text-primary' : '' ?>" href="<?= base_url('informasi/tata-cara-keberatan') ?>">Tata Cara Pengajuan Keberatan</a></li>
                        <li><a class="dropdown-item <?= $segment2 == 'tata-cara-sengketa' ? 'active text-primary' : '' ?>" href="<?= base_url('informasi/tata-cara-sengketa') ?>">Tata Cara Sengketa Informasi</a></li>
                        <li><a class="dropdown-item <?= $segment2 == 'hak-dan-kewajiban' ? 'active text-primary' : '' ?>" href="<?= base_url('informasi/hak-dan-kewajiban') ?>">Hak & Kewajiban Pemohon</a></li>
                    </ul>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= $segment1 == 'informasi-publik' ? 'active' : '' ?>" href="#" id="navbarDIP" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Informasi Publik
                    </a>
                    <ul class="dropdown-menu shadow-lg border-0" aria-labelledby="navbarDIP">
                        <li><a class="dropdown-item <?= $segment2 == 'berkala' ? 'active text-primary' : '' ?>" href="<?= base_url('informasi-publik/berkala') ?>">Informasi Berkala</a></li>
                        <li><a class="dropdown-item <?= $segment2 == 'serta-merta' ? 'active text-primary' : '' ?>" href="<?= base_url('informasi-publik/serta-merta') ?>">Informasi Serta Merta</a></li>
                        <li><a class="dropdown-item <?= $segment2 == 'tersedia' ? 'active text-primary' : '' ?>" href="<?= base_url('informasi-publik/tersedia') ?>">Informasi Tersedia Setiap Saat</a></li>
                        <li><a class="dropdown-item <?= $segment2 == 'dikecualikan' ? 'active text-primary' : '' ?>" href="<?= base_url('informasi-publik/dikecualikan') ?>">Informasi Dikecualikan</a></li>
                    </ul>
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
