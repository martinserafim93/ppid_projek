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
                    <h2 class="heading-font fw-bold mb-4 text-primary text-center"><?= esc($page['title']) ?></h2>
                    
                    <?php if (!empty($page['image'])): ?>
                        <div class="text-center mb-5" data-aos="fade-up">
                            <img src="<?= base_url($page['image']) ?>" alt="<?= esc($page['title']) ?>" class="img-fluid rounded shadow-sm" style="max-height: 400px; object-fit: cover;">
                        </div>
                    <?php endif; ?>

                    <div class="content-body" data-aos="fade-up" data-aos-delay="100">
                        <?= $page['content'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
