<footer class="footer-ppid">
    <div class="container">
        <div class="row justify-content-between g-5">
            <!-- Col 1: Brand & Desc -->
            <div class="col-lg-4 mb-4">
                <div class="d-flex align-items-center mb-4">
                    <img src="<?= base_url(getSetting('site_logo') ?: 'assets/img/kemenag-new-2025.png') ?>" alt="Logo Kemenag" class="me-3" style="height: 55px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.15));">
                    <div>
                        <h4 class="mb-0 text-white heading-font fs-6 lh-base fw-bold"><?= esc(getSetting('site_name') ?? 'PPID Kantor Wilayah Kementerian Agama Provinsi Kalimantan Utara') ?></h4>
                    </div>
                </div>
                
                <p class="mb-4 text-white-50" style="font-size: 15px; line-height: 1.8;">
                    <?= esc(getSetting('site_description') ?? 'Website resmi Pejabat Pengelola Informasi dan Dokumentasi (PPID) Kantor Wilayah Kementerian Agama Provinsi Kalimantan Utara.') ?>
                </p>
                
                <div class="d-flex gap-2 mt-4">
                    <?php if ($fb = getSetting('social_facebook')): ?>
                        <a href="<?= esc($fb) ?>" target="_blank" class="btn btn-outline-light rounded-circle hover-lift d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" aria-label="Facebook"><i class="bi bi-facebook fs-6"></i></a>
                    <?php endif; ?>
                    <?php if ($tw = getSetting('social_twitter')): ?>
                        <a href="<?= esc($tw) ?>" target="_blank" class="btn btn-outline-light rounded-circle hover-lift d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" aria-label="Twitter"><i class="bi bi-twitter-x fs-6"></i></a>
                    <?php endif; ?>
                    <?php if ($ig = getSetting('social_instagram')): ?>
                        <a href="<?= esc($ig) ?>" target="_blank" class="btn btn-outline-light rounded-circle hover-lift d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" aria-label="Instagram"><i class="bi bi-instagram fs-6"></i></a>
                    <?php endif; ?>
                    <?php if ($yt = getSetting('social_youtube')): ?>
                        <a href="<?= esc($yt) ?>" target="_blank" class="btn btn-outline-light rounded-circle hover-lift d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" aria-label="YouTube"><i class="bi bi-youtube fs-6"></i></a>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Col 2: Hubungi Kami -->
            <div class="col-lg-4 mb-4">
                <h5 class="text-white heading-font mb-4 fs-6 text-uppercase fw-bold" style="letter-spacing: 1px;">Hubungi Kami</h5>
                <div class="d-flex align-items-start mb-3 hover-lift">
                    <div class="bg-white bg-opacity-10 text-white p-2 rounded-3 me-3 mt-1 shadow-sm">
                        <i class="bi bi-geo-alt-fill fs-5"></i>
                    </div>
                    <div>
                        <strong class="d-block text-white mb-1">Alamat</strong>
                        <span class="text-white-50" style="font-size: 14px; line-height: 1.6;"><?= esc(getSetting('site_address') ?? 'Jl. Kolonel Soetadji, Tanjung Selor, Kalimantan Utara') ?></span>
                    </div>
                </div>
                <div class="d-flex align-items-start mb-3 hover-lift">
                    <div class="bg-white bg-opacity-10 text-white p-2 rounded-3 me-3 shadow-sm">
                        <i class="bi bi-envelope-fill fs-5"></i>
                    </div>
                    <div>
                        <strong class="d-block text-white mb-1">Email</strong>
                        <span class="text-white-50" style="font-size: 14px;"><?= esc(getSetting('site_email') ?? 'kaltara@kemenag.go.id') ?></span>
                    </div>
                </div>
                <div class="d-flex align-items-start hover-lift">
                    <div class="bg-white bg-opacity-10 text-white p-2 rounded-3 me-3 shadow-sm">
                        <i class="bi bi-telephone-fill fs-5"></i>
                    </div>
                    <div>
                        <strong class="d-block text-white mb-1">Telepon</strong>
                        <span class="text-white-50" style="font-size: 14px;"><?= esc(getSetting('site_phone') ?? '(0552) 2033004') ?></span>
                    </div>
                </div>
            </div>
            
            <!-- Col 3: Waktu Layanan -->
            <div class="col-lg-3 mb-4">
                <h5 class="text-white heading-font mb-4 fs-6 text-uppercase fw-bold" style="letter-spacing: 1px;">Waktu Layanan</h5>
                <div class="d-flex align-items-start hover-lift">
                    <div class="bg-white bg-opacity-10 text-white p-2 rounded-3 me-3 shadow-sm">
                        <i class="bi bi-clock-history fs-5"></i>
                    </div>
                    <div>
                        <strong class="d-block text-white mb-1">Jam Operasional</strong>
                        <span class="text-white-50" style="font-size: 14px; line-height: 1.6;"><?= esc(getSetting('operating_hours') ?? 'Senin-Jumat, 08:00-16:00') ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="footer-bottom text-center">
        <div class="container">
            <p class="mb-0 text-white-50 small">
                <?= esc(getSetting('footer_text') ?? '&copy; ' . date('Y') . ' ' . (getSetting('site_name') ?? 'PPID Kanwil Kemenag Kaltara') . '. Hak Cipta Dilindungi.') ?>
            </p>
        </div>
    </div>
</footer>
