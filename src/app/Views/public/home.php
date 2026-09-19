<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>

<!-- HERO SECTION -->
<section class="hero-section">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-up">
                <h1 class="hero-title">
                    Selamat Datang di Portal PPID<br>
                    <span style="color: var(--accent-light);">Kanwil Kemenag Kalimantan Utara</span>
                </h1>
                <p class="hero-subtitle">
                    Wujud komitmen kami dalam memberikan layanan informasi publik yang transparan, akuntabel, dan mudah diakses oleh seluruh lapisan masyarakat.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <?php if(session()->get('logged_in')): ?>
                        <a href="<?= base_url('permohonan/buat') ?>" class="btn btn-accent btn-lg px-4 shadow-sm">
                            <i class="bi bi-file-earmark-text me-2"></i> Daftarkan Permohonan
                        </a>
                    <?php else: ?>
                        <button type="button" class="btn btn-accent btn-lg px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#registerModal">
                            <i class="bi bi-file-earmark-text me-2"></i> Daftarkan Permohonan
                        </button>
                    <?php endif; ?>
                    <?php if($survei = getSetting('survei_link')): ?>
                        <a href="<?= esc($survei) ?>" target="_blank" class="btn btn-outline-light btn-lg px-4">
                            <i class="bi bi-ui-checks me-2"></i> Survei Kepuasan
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center" data-aos="fade-left" data-aos-delay="200">
                <img src="<?= base_url('assets/img/kemenag-new-2025.png') ?>" alt="Logo Kemenag" class="img-fluid" style="max-height: 280px; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2));">
            </div>
        </div>
    </div>
</section>

<!-- QUICK ACCESS SECTION -->
<section class="py-5" style="margin-top: -60px; position: relative; z-index: 3;">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <!-- Card 1 -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <a href="<?= base_url('informasi-publik/berkala') ?>" class="text-decoration-none">
                    <div class="card-glass p-4 text-center h-100">
                        <div class="card-icon bg-icon-primary mx-auto">
                            <i class="bi bi-journal-text"></i>
                        </div>
                        <h5 class="heading-font fs-6 mb-2 text-dark">Informasi Berkala</h5>
                        <p class="text-muted small mb-0">Informasi yang wajib disediakan dan diumumkan secara berkala.</p>
                    </div>
                </a>
            </div>
            
            <!-- Card 2 -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <a href="<?= base_url('informasi-publik/tersedia') ?>" class="text-decoration-none">
                    <div class="card-glass p-4 text-center h-100">
                        <div class="card-icon bg-icon-accent mx-auto">
                            <i class="bi bi-archive"></i>
                        </div>
                        <h5 class="heading-font fs-6 mb-2 text-dark">Informasi Tersedia</h5>
                        <p class="text-muted small mb-0">Informasi yang tersedia setiap saat dan dapat diakses publik.</p>
                    </div>
                </a>
            </div>
            
            <!-- Card 3 -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <a href="<?= base_url('regulasi') ?>" class="text-decoration-none">
                    <div class="card-glass p-4 text-center h-100">
                        <div class="card-icon bg-icon-primary mx-auto">
                            <i class="bi bi-bank"></i>
                        </div>
                        <h5 class="heading-font fs-6 mb-2 text-dark">Regulasi & Hukum</h5>
                        <p class="text-muted small mb-0">Kumpulan peraturan dan pedoman terkait Keterbukaan Informasi Publik.</p>
                    </div>
                </a>
            </div>
            
            <!-- Card 4 -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <a href="<?= base_url('layanan/maklumat-pelayanan') ?>" class="text-decoration-none">
                    <div class="card-glass p-4 text-center h-100">
                        <div class="card-icon bg-icon-accent mx-auto">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h5 class="heading-font fs-6 mb-2 text-dark">Standar Layanan</h5>
                        <p class="text-muted small mb-0">Maklumat, pedoman, jadwal, serta prosedur standar operasional PPID.</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- COUNTER STATISTIK SECTION -->
<section class="py-5 bg-white border-top border-bottom">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-4" data-aos="fade-up">
                <div class="display-4 fw-bold text-primary mb-2 counter" data-target="<?= $totalRequests ?>">0</div>
                <div class="text-muted text-uppercase fw-semibold" style="letter-spacing: 1px; font-size: 0.9rem;">Total Permohonan</div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="display-4 fw-bold text-primary mb-2 counter" data-target="<?= $totalInfo ?>">0</div>
                <div class="text-muted text-uppercase fw-semibold" style="letter-spacing: 1px; font-size: 0.9rem;">Informasi Publik</div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="display-4 fw-bold text-primary mb-2 counter" data-target="<?= $totalDocs ?>">0</div>
                <div class="text-muted text-uppercase fw-semibold" style="letter-spacing: 1px; font-size: 0.9rem;">Dokumen & Laporan</div>
            </div>
        </div>
    </div>
</section>

<!-- INFORMASI TERBARU SECTION -->
<section class="py-5" style="background-color: var(--bg-light);">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h6 class="text-primary fw-bold text-uppercase" style="letter-spacing: 2px;">Update Terkini</h6>
                <h2 class="heading-font fw-bold mb-0">Informasi Publik Terbaru</h2>
            </div>
            <a href="<?= base_url('informasi-publik/berkala') ?>" class="btn btn-outline-primary-custom d-none d-md-inline-flex align-items-center">
                Lihat Semua <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
        
        <div class="row g-4">
            <?php if(empty($latestInfo)): ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada informasi publik.</p>
                </div>
            <?php else: ?>
                <?php foreach($latestInfo as $index => $info): ?>
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                        <div class="card border-0 shadow-sm h-100 p-4" style="border-radius: var(--radius-lg); transition: var(--transition);">
                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-light p-3 rounded text-primary text-center" style="min-width: 80px;">
                                    <div class="fs-4 fw-bold heading-font"><?= date('d', strtotime($info['created_at'])) ?></div>
                                    <div class="small fw-medium text-uppercase"><?= date('M Y', strtotime($info['created_at'])) ?></div>
                                </div>
                                <div>
                                    <span class="badge bg-primary bg-opacity-10 text-primary mb-2 px-3 py-2 rounded-pill fw-medium">
                                        <?= ucwords(str_replace('_', ' ', $info['category'])) ?>
                                    </span>
                                    <h5 class="heading-font fs-6 mb-3 line-clamp-2">
                                        <a href="<?= base_url('informasi-publik/' . $info['category']) ?>" class="text-dark text-decoration-none text-hover-primary"><?= esc($info['title']) ?></a>
                                    </h5>
                                    
                                    <div class="d-flex gap-3 mt-auto">
                                        <?php if(!empty($info['file_path'])): ?>
                                            <a href="<?= base_url($info['file_path']) ?>" target="_blank" class="text-primary text-decoration-none small fw-medium">
                                                <i class="bi bi-download me-1"></i> Unduh Lampiran
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-5 d-md-none">
            <a href="<?= base_url('informasi-publik/berkala') ?>" class="btn btn-outline-primary-custom w-100">
                Lihat Semua Informasi
            </a>
        </div>
    </div>
</section>

<!-- INFOGRAFIS SECTION -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase" style="letter-spacing: 2px;">Galeri Visual</h6>
            <h2 class="heading-font fw-bold">Infografis & Edukasi Publik</h2>
            <p class="text-muted max-w-700 mx-auto mt-3">Ringkasan informasi dalam bentuk visual yang mudah dipahami.</p>
        </div>
        
        <div class="row g-4">
            <?php if(empty($infographics)): ?>
                <div class="col-12 text-center py-4">
                    <p class="text-muted">Belum ada infografis.</p>
                </div>
            <?php else: ?>
                <?php foreach($infographics as $index => $ig): ?>
                    <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="<?= $index * 100 ?>">
                        <div class="card border-0 shadow-sm h-100 overflow-hidden" style="border-radius: var(--radius-lg);">
                            <a href="<?= base_url($ig['image_path']) ?>" class="glightbox d-block position-relative" data-title="<?= esc($ig['title']) ?>" data-description="<?= esc($ig['description']) ?>">
                                <div class="position-relative" style="padding-top: 100%; overflow: hidden;">
                                    <img src="<?= base_url($ig['image_path']) ?>" class="position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover; transition: transform 0.5s;" alt="<?= esc($ig['title']) ?>" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                </div>
                                <div class="position-absolute bottom-0 start-0 w-100 p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                                    <h6 class="text-white mb-0 text-truncate"><?= esc($ig['title']) ?></h6>
                                </div>
                                <div class="position-absolute top-50 start-50 translate-middle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; opacity: 0; transition: var(--transition);">
                                    <i class="bi bi-zoom-in fs-4"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-5">
            <a href="<?= base_url('infografis') ?>" class="btn btn-primary-custom px-5">
                Lihat Galeri Lengkap
            </a>
        </div>
    </div>
</section>

<!-- SHORTCUT LINKS -->
<section class="py-5" style="background-color: var(--primary-dark);">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-md-2 col-6 text-center">
                <a href="https://lpse.kemenag.go.id/" target="_blank" class="text-decoration-none text-white d-block opacity-75 hover-opacity-100" style="transition: var(--transition);">
                    <div class="bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-cart3 fs-3"></i>
                    </div>
                    <span class="small fw-medium">LPSE</span>
                </a>
            </div>
            <div class="col-md-2 col-6 text-center">
                <a href="https://simdumas.kemenag.go.id/" target="_blank" class="text-decoration-none text-white d-block opacity-75 hover-opacity-100" style="transition: var(--transition);">
                    <div class="bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-megaphone fs-3"></i>
                    </div>
                    <span class="small fw-medium">Pengaduan Masyarakat</span>
                </a>
            </div>
            <div class="col-md-2 col-6 text-center">
                <a href="https://kemenag.go.id/" target="_blank" class="text-decoration-none text-white d-block opacity-75 hover-opacity-100" style="transition: var(--transition);">
                    <div class="bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-building fs-3"></i>
                    </div>
                    <span class="small fw-medium">Unit Kerja Kemenag</span>
                </a>
            </div>
            <div class="col-md-2 col-6 text-center">
                <a href="https://rb.kemenag.go.id/" target="_blank" class="text-decoration-none text-white d-block opacity-75 hover-opacity-100" style="transition: var(--transition);">
                    <div class="bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-award fs-3"></i>
                    </div>
                    <span class="small fw-medium">Reformasi Birokrasi</span>
                </a>
            </div>
            <div class="col-md-2 col-6 text-center">
                <a href="<?= esc(getSetting('whatsapp_link') ?? 'https://wa.me/6281234567890') ?>" target="_blank" class="text-decoration-none text-white d-block opacity-75 hover-opacity-100" style="transition: var(--transition);">
                    <div class="bg-white bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-whatsapp fs-3"></i>
                    </div>
                    <span class="small fw-medium">Layanan WhatsApp</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header border-0 pb-0 justify-content-end">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-0 text-center">
                <div class="bg-primary-custom-subtle text-primary-custom rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                    <i class="bi bi-shield-lock-fill" style="font-size: 2.5rem;"></i>
                </div>
                <h4 class="fw-bold text-dark mb-3">Autentikasi Diperlukan</h4>
                <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
                    Untuk keamanan privasi dan agar Anda dapat memantau status permohonan informasi secara real-time, silakan masuk atau daftar akun terlebih dahulu.
                </p>
                <div class="d-grid gap-3 mx-auto" style="max-width: 350px;">
                    <a href="<?= base_url('user/login') ?>" class="btn btn-primary-custom py-2 rounded-pill fw-medium shadow-sm hover-lift">
                        Masuk ke Akun
                    </a>
                    <a href="<?= base_url('user/register') ?>" class="btn btn-outline-primary-custom py-2 rounded-pill fw-medium hover-lift">
                        Belum punya akun? Daftar
                    </a>
                    <?php if($form = getSetting('form_manual')): ?>
                        <div class="position-relative my-2">
                            <hr class="text-muted opacity-25">
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-2 small text-muted">ATAU</span>
                        </div>
                        <a href="<?= base_url($form) ?>" target="_blank" class="btn btn-light py-2 text-muted border rounded-pill hover-lift">
                            <i class="bi bi-download me-1"></i> Unduh Form Manual (PDF)
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Hover effect for lightbox icon
    $('.glightbox').hover(
        function() { $(this).find('.translate-middle').css('opacity', '1'); },
        function() { $(this).find('.translate-middle').css('opacity', '0'); }
    );
    
    // Add hover opacity class for shortcut links
    $('<style>.hover-opacity-100:hover { opacity: 1 !important; }</style>').appendTo('head');
    $('<style>.text-hover-primary:hover { color: var(--primary) !important; }</style>').appendTo('head');
    
    // Counter Animation
    const counters = document.querySelectorAll('.counter');
    const speed = 200;

    const runCounter = () => {
        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 20);
                } else {
                    counter.innerText = target;
                }
            };
            
            // Only run when in view
            const rect = counter.getBoundingClientRect();
            if(rect.top < window.innerHeight && rect.bottom > 0) {
                if(counter.innerText == '0') {
                    updateCount();
                }
            }
        });
    };
    
    window.addEventListener('scroll', runCounter);
    // Initial check
    setTimeout(runCounter, 500);
</script>
<?= $this->endSection() ?>
