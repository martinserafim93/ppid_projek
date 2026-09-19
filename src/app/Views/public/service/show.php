<?= $this->extend('layouts/public') ?>

<?= $this->section('breadcrumb') ?>
<?= $this->include('components/breadcrumb') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="py-5" style="background-color: var(--bg-light); min-height: 60vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card-glass border-0 p-4 p-md-5">

                    <?php if (!empty($page['image'])): ?>
                        <div class="text-center mb-5" data-aos="fade-up" data-aos-delay="100">
                            <img src="<?= base_url($page['image']) ?>" alt="<?= esc($page['title']) ?>" class="img-fluid rounded shadow-sm" style="max-height: 500px; object-fit: contain;">
                        </div>
                    <?php endif; ?>

                    <div class="content-body" data-aos="fade-up" data-aos-delay="200">
                        <?= $page['content'] ?>
                    </div>
                    
                    <?php if (!empty($page['file_path'])): ?>
                        <div class="mt-5 pt-4 border-top" data-aos="fade-up" data-aos-delay="300">
                            <h5 class="fw-bold mb-3"><i class="bi bi-paperclip me-2 text-primary"></i>Lampiran Dokumen</h5>
                            <a href="<?= base_url($page['file_path']) ?>" target="_blank" class="btn btn-outline-primary rounded-pill px-4 hover-lift">
                                <i class="bi bi-download me-2"></i>Unduh Lampiran
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
