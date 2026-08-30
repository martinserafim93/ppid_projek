<footer class="footer-ppid">
    <div class="container">
        <div class="row justify-content-between g-5">
            <!-- Col 1: Instansi Info -->
            <div class="col-lg-6 mb-4">
                <div class="d-flex align-items-center mb-4">
                    <img src="<?= base_url(getSetting('site_logo') ?: 'assets/img/kemenag-new-2025.png') ?>" alt="Logo Kemenag" class="me-3" style="height: 55px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                    <div>
                        <h4 class="mb-0 text-white heading-font fs-5 lh-base"><?= esc(getSetting('site_name') ?? 'PPID Kantor Wilayah Kementerian Agama Provinsi Kalimantan Utara') ?></h4>
                    </div>
                </div>
                
                <p class="mb-5 text-white-50 pe-lg-4" style="font-size: 15px; line-height: 1.8;">
                    <?= esc(getSetting('site_description') ?? 'Website resmi Pejabat Pengelola Informasi dan Dokumentasi (PPID) Kantor Wilayah Kementerian Agama Provinsi Kalimantan Utara.') ?>
                </p>
                
                <div class="row g-4">
                    <div class="col-12">
                        <div class="d-flex align-items-start">
                            <div class="bg-white bg-opacity-10 p-2 rounded-3 me-3 text-white">
                                <i class="bi bi-geo-alt fs-5"></i>
                            </div>
                            <div>
                                <strong class="d-block text-white mb-1">Alamat</strong>
                                <span class="text-white-50" style="font-size: 14px; line-height: 1.6;"><?= esc(getSetting('site_address') ?? 'Jl. Kolonel Soetadji, Tanjung Selor, Kalimantan Utara') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start">
                            <div class="bg-white bg-opacity-10 p-2 rounded-3 me-3 text-white">
                                <i class="bi bi-envelope fs-5"></i>
                            </div>
                            <div>
                                <strong class="d-block text-white mb-1">Email</strong>
                                <span class="text-white-50" style="font-size: 14px;"><?= esc(getSetting('site_email') ?? 'kaltara@kemenag.go.id') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start">
                            <div class="bg-white bg-opacity-10 p-2 rounded-3 me-3 text-white">
                                <i class="bi bi-telephone fs-5"></i>
                            </div>
                            <div>
                                <strong class="d-block text-white mb-1">Telepon</strong>
                                <span class="text-white-50" style="font-size: 14px;"><?= esc(getSetting('site_phone') ?? '(0552) 2033004') ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Col 2: Waktu Layanan & Sosial Media -->
            <div class="col-lg-5 col-xl-4 mb-4">
                <div class="p-4 rounded-4 mb-5" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                    <h5 class="text-white heading-font mb-4 fs-6 text-uppercase" style="letter-spacing: 1px;">Waktu Layanan</h5>
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-25 p-3 rounded-circle me-4 d-flex align-items-center justify-content-center">
                            <i class="bi bi-clock-history fs-3 text-white"></i>
                        </div>
                        <div>
                            <span class="text-white-50 d-block mb-1 fs-6">Jam Operasional</span>
                            <span class="text-white fw-semibold fs-5"><?= esc(getSetting('operating_hours') ?? 'Senin-Jumat, 08:00-16:00') ?></span>
                        </div>
                    </div>
                </div>
                
                <h5 class="text-white heading-font mb-3 fs-6 text-uppercase" style="letter-spacing: 1px;">Ikuti Kami</h5>
                <div class="d-flex gap-3">
                    <?php if ($fb = getSetting('social_facebook')): ?>
                        <a href="<?= esc($fb) ?>" target="_blank" class="btn btn-outline-light rounded-circle transition-all d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;" aria-label="Facebook"><i class="bi bi-facebook fs-5"></i></a>
                    <?php endif; ?>
                    <?php if ($tw = getSetting('social_twitter')): ?>
                        <a href="<?= esc($tw) ?>" target="_blank" class="btn btn-outline-light rounded-circle transition-all d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;" aria-label="Twitter"><i class="bi bi-twitter-x fs-5"></i></a>
                    <?php endif; ?>
                    <?php if ($ig = getSetting('social_instagram')): ?>
                        <a href="<?= esc($ig) ?>" target="_blank" class="btn btn-outline-light rounded-circle transition-all d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;" aria-label="Instagram"><i class="bi bi-instagram fs-5"></i></a>
                    <?php endif; ?>
                    <?php if ($yt = getSetting('social_youtube')): ?>
                        <a href="<?= esc($yt) ?>" target="_blank" class="btn btn-outline-light rounded-circle transition-all d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;" aria-label="YouTube"><i class="bi bi-youtube fs-5"></i></a>
                    <?php endif; ?>
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
