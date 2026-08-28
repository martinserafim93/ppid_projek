<?= $this->extend('layouts/public') ?>

<?= $this->section('breadcrumb') ?>
<?= $this->include('components/breadcrumb') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="py-5" style="background-color: var(--bg-light); min-height: 70vh;">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary fw-bold text-uppercase" style="letter-spacing: 2px;">Galeri Visual</h6>
            <h2 class="heading-font fw-bold">Infografis & Edukasi Publik</h2>
            <p class="text-muted max-w-700 mx-auto mt-3">Kumpulan informasi visual yang dirancang untuk memudahkan pemahaman publik mengenai berbagai prosedur, data, dan program kerja.</p>
        </div>

        <div class="row g-4" data-masonry='{"percentPosition": true }'>
            <?php if (empty($infographics)): ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada infografis yang tersedia.</p>
                </div>
            <?php else: ?>
                <?php foreach ($infographics as $index => $ig): ?>
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="zoom-in" data-aos-delay="<?= ($index % 3) * 100 ?>">
                        <div class="card border-0 shadow-sm h-100 overflow-hidden" style="border-radius: var(--radius-lg);">
                            <a href="<?= base_url($ig['image']) ?>" class="glightbox d-block position-relative" data-title="<?= esc($ig['title']) ?>" data-description="<?= esc($ig['description']) ?>">
                                <div class="position-relative" style="padding-top: 100%; overflow: hidden;">
                                    <!-- Using square aspect ratio container for uniform grid, but image covers it -->
                                    <img src="<?= base_url($ig['image']) ?>" class="position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover; transition: transform 0.5s;" alt="<?= esc($ig['title']) ?>" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                </div>
                                <div class="position-absolute bottom-0 start-0 w-100 p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                                    <h6 class="text-white mb-0 line-clamp-2"><?= esc($ig['title']) ?></h6>
                                </div>
                                <div class="position-absolute top-50 start-50 translate-middle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; opacity: 0; transition: var(--transition);">
                                    <i class="bi bi-zoom-in fs-4"></i>
                                </div>
                            </a>
                            <?php if(!empty($ig['description'])): ?>
                            <div class="card-body bg-white">
                                <p class="card-text text-muted small mb-0 line-clamp-3"><?= esc($ig['description']) ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php if ($pager->getPageCount() > 1): ?>
            <div class="mt-5 d-flex justify-content-center">
                <?= $pager->links('default', 'bootstrap_pagination') ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Masonry JS for grid layout -->
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
<script>
    // Hover effect for lightbox icon
    $('.glightbox').hover(
        function() { $(this).find('.translate-middle').css('opacity', '1'); },
        function() { $(this).find('.translate-middle').css('opacity', '0'); }
    );
</script>
<?= $this->endSection() ?>
