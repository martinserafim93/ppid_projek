<?= $this->extend('layouts/public') ?>

<?= $this->section('breadcrumb') ?>
<?= $this->include('components/breadcrumb') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="py-5" style="background-color: var(--bg-light); min-height: 70vh;">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary fw-bold text-uppercase" style="letter-spacing: 2px;">Produk Hukum</h6>
            <h2 class="heading-font fw-bold">Regulasi Keterbukaan Informasi</h2>
            <p class="text-muted max-w-700 mx-auto mt-3">Kumpulan peraturan perundang-undangan dan pedoman terkait Keterbukaan Informasi Publik di lingkungan PPID.</p>
        </div>

        <div class="card-glass border-0 p-4 mb-4" data-aos="fade-up" data-aos-delay="100">
            <form action="<?= base_url('regulasi') ?>" method="GET" class="row g-3 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Cari judul atau nomor regulasi..." value="<?= esc($search ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="type" class="form-select">
                        <option value="">-- Semua Tipe Regulasi --</option>
                        <option value="Undang-Undang" <?= ($type ?? '') == 'Undang-Undang' ? 'selected' : '' ?>>Undang-Undang</option>
                        <option value="Peraturan Pemerintah" <?= ($type ?? '') == 'Peraturan Pemerintah' ? 'selected' : '' ?>>Peraturan Pemerintah</option>
                        <option value="Peraturan Menteri" <?= ($type ?? '') == 'Peraturan Menteri' ? 'selected' : '' ?>>Peraturan Menteri (PMA)</option>
                        <option value="Peraturan Komisi Informasi" <?= ($type ?? '') == 'Peraturan Komisi Informasi' ? 'selected' : '' ?>>Peraturan Komisi Informasi</option>
                        <option value="Surat Keputusan" <?= ($type ?? '') == 'Surat Keputusan' ? 'selected' : '' ?>>Surat Keputusan</option>
                        <option value="Lainnya" <?= ($type ?? '') == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </div>
                <div class="col-md-3 d-grid d-md-flex gap-2">
                    <button type="submit" class="btn btn-primary-custom flex-grow-1">Filter</button>
                    <?php if(!empty($search) || !empty($type)): ?>
                        <a href="<?= base_url('regulasi') ?>" class="btn btn-outline-secondary">Reset</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="card-glass border-0 overflow-hidden" data-aos="fade-up" data-aos-delay="200">
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="15%">Tipe Regulasi</th>
                            <th width="20%">Nomor / Tahun</th>
                            <th width="45%">Judul / Tentang</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($regulations)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    Regulasi tidak ditemukan.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1 + (10 * ($pager->getCurrentPage() - 1)); ?>
                            <?php foreach ($regulations as $reg): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-medium">
                                            <?= esc($reg['type']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <strong><?= esc($reg['regulation_number']) ?></strong>
                                        <div class="small text-muted">Tahun <?= esc($reg['year']) ?></div>
                                    </td>
                                    <td>
                                        <div class="fw-medium text-dark line-clamp-2" title="<?= esc($reg['title']) ?>">
                                            <?= esc($reg['title']) ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <?php if (!empty($reg['file_path'])): ?>
                                            <a href="<?= base_url($reg['file_path']) ?>" target="_blank" class="btn btn-sm btn-outline-primary-custom" title="Unduh PDF">
                                                <i class="bi bi-download me-1"></i> Unduh
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
                <div class="p-4 border-top d-flex justify-content-center">
                    <?= $pager->links('default', 'bootstrap_pagination') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
