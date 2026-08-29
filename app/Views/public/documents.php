<?= $this->extend('layouts/public') ?>

<?= $this->section('breadcrumb') ?>
<?= $this->include('components/breadcrumb') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="py-5" style="background-color: var(--bg-light); min-height: 70vh;">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary fw-bold text-uppercase" style="letter-spacing: 2px;">Dokumen</h6>
            <h2 class="heading-font fw-bold"><?= esc($title) ?></h2>
            <?php if (!empty($category['description'])): ?>
                <p class="text-muted max-w-700 mx-auto mt-3"><?= esc($category['description']) ?></p>
            <?php endif; ?>
        </div>

        <div class="card-glass border-0 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
            <div class="p-4 bg-white border-bottom">
                <form action="<?= current_url() ?>" method="GET" class="row justify-content-end">
                    <div class="col-md-5">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari dokumen..." value="<?= esc($search ?? '') ?>">
                            <button class="btn btn-primary-custom" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="75%">Nama Dokumen</th>
                            <th width="20%" class="text-center">Link Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($documents)): ?>
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
                                    Dokumen belum tersedia.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1 + (10 * ($pager->getCurrentPage() - 1)); ?>
                            <?php foreach ($documents as $doc): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td>
                                        <div class="fw-medium text-dark"><?= esc($doc['title']) ?></div>
                                        <?php if (!empty($doc['description'])): ?>
                                            <div class="small text-muted"><?= esc($doc['description']) ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if (!empty($doc['file_path'])): ?>
                                            <a href="<?= base_url('dokumen/download/' . $doc['id']) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary-custom">
                                                <i class="bi bi-file-earmark-text me-1"></i> Lihat Dokumen
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small">Tidak ada file</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($pager->getPageCount() > 1): ?>
                <div class="p-4 d-flex justify-content-center border-top bg-white">
                    <?= $pager->links('default', 'bootstrap_pagination') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
