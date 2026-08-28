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
                    <div class="text-center mb-5" data-aos="fade-up">
                        <h2 class="heading-font fw-bold text-primary"><?= esc($page['title']) ?></h2>
                        <div class="mx-auto mt-3" style="width: 60px; height: 4px; background-color: var(--accent); border-radius: 2px;"></div>
                    </div>
                    
                    <?php if (!empty($page['image'])): ?>
                        <div class="text-center mb-5" data-aos="fade-up" data-aos-delay="100">
                            <img src="<?= base_url($page['image']) ?>" alt="<?= esc($page['title']) ?>" class="img-fluid rounded shadow-sm" style="max-height: 500px; object-fit: contain;">
                        </div>
                    <?php endif; ?>

                    <div class="content-body" data-aos="fade-up" data-aos-delay="200">
                        <?= $page['content'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
