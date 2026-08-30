<?= $this->extend('layouts/public') ?>
<?= $this->section('breadcrumb') ?>
<?= $this->include('components/breadcrumb') ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<section class="py-5" style="background-color: var(--bg-light); min-height: 60vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-9">
        <div class="card-glass border-0 p-4 p-md-5" data-aos="fade-up">
          <?php if (!empty($category)): ?>
            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-medium mb-3">
              <?= esc($category['name']) ?>
            </span>
          <?php endif; ?>
          <h2 class="heading-font fw-bold mb-3"><?= esc($regulation['title']) ?></h2>
          <div class="text-muted mb-4">
            <?php if (!empty($regulation['number'])): ?>Nomor: <strong><?= esc($regulation['number']) ?></strong><?php endif; ?>
            <?php if (!empty($regulation['year'])): ?> &middot; Tahun <?= esc($regulation['year']) ?><?php endif; ?>
          </div>
          <?php if (!empty($regulation['description'])): ?>
            <p class="lead"><?= nl2br(esc($regulation['description'])) ?></p>
          <?php endif; ?>
          <?php if (!empty($regulation['file_path'])): ?>
            <div class="mt-4 pt-4 border-top">
              <a href="<?= base_url($regulation['file_path']) ?>" target="_blank" class="btn btn-outline-primary rounded-pill px-4 hover-lift">
                <i class="bi bi-download me-2"></i>Unduh Dokumen PDF
              </a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection() ?>
