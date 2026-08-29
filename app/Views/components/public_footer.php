<footer class="footer-ppid">
    <div class="container">
        <div class="row g-4">
            <!-- Col 1: Instansi Info -->
            <div class="col-lg-5 mb-4">
                <div class="d-flex align-items-center mb-3">
                    <img src="<?= base_url('assets/img/kemenag-new-2025.png') ?>" alt="Logo Kemenag" class="me-3" style="height: 50px;">
                    <div>
                        <h4 class="mb-0 text-white heading-font fs-5">PPID Kantor Wilayah Kementerian Agama Provinsi Kalimantan Utara</h4>
                    </div>
                </div>
                <p class="mb-4 text-white-50" style="font-size: 14px; line-height: 1.8;">
                    <?= esc(getSetting('site_description') ?? 'Website resmi Pejabat Pengelola Informasi dan Dokumentasi (PPID) Kantor Wilayah Kementerian Agama Provinsi Kalimantan Utara.') ?>
                </p>
                
                <div class="footer-contact-item">
                    <i class="bi bi-geo-alt"></i>
                    <div>
                        <strong class="d-block text-white mb-1">Alamat</strong>
                        <span class="text-white-50 small"><?= esc(getSetting('address') ?? 'Jl. Kolonel Soetadji, Tanjung Selor, Kalimantan Utara') ?></span>
                    </div>
                </div>
                
                <div class="footer-contact-item">
                    <i class="bi bi-envelope"></i>
                    <div>
                        <strong class="d-block text-white mb-1">Email</strong>
                        <span class="text-white-50 small"><?= esc(getSetting('email') ?? 'kaltara@kemenag.go.id') ?></span>
                    </div>
                </div>
                
                <div class="footer-contact-item">
                    <i class="bi bi-telephone"></i>
                    <div>
                        <strong class="d-block text-white mb-1">Telepon</strong>
                        <span class="text-white-50 small"><?= esc(getSetting('phone') ?? '(0552) 123456') ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Col 2: Quick Links -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="footer-title heading-font">Tautan Cepat</h5>
                <ul class="list-unstyled">
                    <li><a href="<?= base_url('profil/sejarah-kanwil') ?>" class="footer-link">Profil PPID</a></li>
                    <li><a href="<?= base_url('regulasi') ?>" class="footer-link">Regulasi</a></li>
                    <li><a href="<?= base_url('informasi-publik/berkala') ?>" class="footer-link">Informasi Berkala</a></li>
                    <li><a href="<?= base_url('layanan/maklumat-pelayanan') ?>" class="footer-link">Maklumat Pelayanan</a></li>
                    <li><a href="<?= base_url('data') ?>" class="footer-link">Data & Statistik</a></li>
                    <li><a href="<?= base_url('user/login') ?>" class="footer-link">Login Pemohon</a></li>
                </ul>
            </div>
            
            <!-- Col 3: Waktu Layanan & Sosial Media -->
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="footer-title heading-font">Waktu Layanan</h5>
                <div class="p-3 rounded mb-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-white-50">Senin - Kamis</span>
                        <span class="text-white fw-medium">08:00 - 16:00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-white-50">Jumat</span>
                        <span class="text-white fw-medium">08:00 - 16:30</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-white-50">Sabtu & Minggu</span>
                        <span class="text-danger">Tutup</span>
                    </div>
                </div>
                
                <h5 class="footer-title heading-font mb-3">Sosial Media</h5>
                <div class="d-flex gap-2">
                    <?php if ($fb = getSetting('social_facebook')): ?>
                        <a href="<?= esc($fb) ?>" target="_blank" class="btn btn-outline-light rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-facebook"></i></a>
                    <?php endif; ?>
                    <?php if ($tw = getSetting('social_twitter')): ?>
                        <a href="<?= esc($tw) ?>" target="_blank" class="btn btn-outline-light rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-twitter-x"></i></a>
                    <?php endif; ?>
                    <?php if ($ig = getSetting('social_instagram')): ?>
                        <a href="<?= esc($ig) ?>" target="_blank" class="btn btn-outline-light rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-instagram"></i></a>
                    <?php endif; ?>
                    <?php if ($yt = getSetting('social_youtube')): ?>
                        <a href="<?= esc($yt) ?>" target="_blank" class="btn btn-outline-light rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-youtube"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="footer-bottom text-center">
        <div class="container">
            <p class="mb-0 text-white-50 small">
                &copy; <?= date('Y') ?> <?= esc(getSetting('site_name') ?? 'PPID Kanwil Kemenag Kaltara') ?>. Hak Cipta Dilindungi.<br>
                Dikembangkan oleh Tim IT Kanwil Kemenag Provinsi Kalimantan Utara.
            </p>
        </div>
    </div>
</footer>
