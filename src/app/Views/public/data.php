<?= $this->extend('layouts/public') ?>

<?= $this->section('breadcrumb') ?>
<?= $this->include('components/breadcrumb') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="py-5" style="background-color: var(--bg-light); min-height: 70vh;">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary fw-bold text-uppercase" style="letter-spacing: 2px;">Publikasi Laporan</h6>
            <h2 class="heading-font fw-bold">Dokumen dan Statistik Tahunan</h2>
            <p class="text-muted max-w-700 mx-auto mt-3">Laporan statistik dan dokumen data sektoral yang dipublikasikan oleh Kantor Wilayah Kementerian Agama Provinsi Kalimantan Utara.</p>
        </div>

        <div class="card-glass border-0 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
            <div class="p-4 bg-white border-bottom">
                <form action="<?= base_url('data') ?>" method="GET" class="row justify-content-end">
                    <div class="col-md-5">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari dokumen/laporan statistik..." value="<?= esc($search ?? '') ?>">
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
                            <th width="60%">Judul Dokumen</th>
                            <th width="15%" class="text-center">Tahun</th>
                            <th width="20%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($documents)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-file-earmark-bar-graph fs-1 d-block mb-2"></i>
                                    Dokumen statistik belum tersedia.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1 + (10 * ($pager->getCurrentPage() - 1)); ?>
                            <?php foreach ($documents as $doc): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td>
                                        <div class="fw-medium text-dark line-clamp-2">
                                            <?= esc($doc['title']) ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary bg-opacity-10 text-primary fs-6">
                                            <?= esc(date('Y', strtotime($doc['created_at']))) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if (!empty($doc['file_path'])): ?>
                                            <a href="<?= base_url($doc['file_path']) ?>" target="_blank" class="btn btn-sm btn-outline-primary-custom">
                                                <i class="bi bi-download me-1"></i> Unduh File
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small">Tidak ada lampiran</span>
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
