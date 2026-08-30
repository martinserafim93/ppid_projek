<?= $this->extend('layouts/public') ?>

<?= $this->section('breadcrumb') ?>
<?= $this->include('components/breadcrumb') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="py-5" style="background-color: var(--bg-light); min-height: 70vh;">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary fw-bold text-uppercase" style="letter-spacing: 2px;">Daftar Informasi Publik</h6>
            <h2 class="heading-font fw-bold">Keterbukaan Informasi Publik</h2>
            <p class="text-muted max-w-700 mx-auto mt-3">Temukan berbagai informasi publik yang disediakan oleh PPID Kanwil Kemenag Provinsi Kalimantan Utara berdasarkan kategorinya.</p>
        </div>

        <div class="card-glass border-0 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
            <!-- Nav Tabs -->
            <ul class="nav nav-tabs nav-tabs-custom px-4 pt-4 pb-1 border-bottom-0 mb-0 d-flex flex-nowrap" id="infoTab" role="tablist" style="overflow-x: auto; overflow-y: hidden;">
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $cat): ?>
                        <li class="nav-item flex-shrink-0" role="presentation">
                            <a class="nav-link <?= $activeTab === $cat['slug'] ? 'active' : '' ?>" href="<?= base_url('informasi-publik/' . $cat['slug']) ?>">
                                <i class="bi bi-folder2-open me-2"></i><?= esc($cat['name']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>

            <div class="p-4 bg-white">
                <!-- Search -->
                <form action="<?= base_url('informasi-publik/' . $activeTab) ?>" method="GET" class="mb-4">
                    <div class="row justify-content-end g-3">
                        <div class="col-md-4 col-lg-3">
                            <select name="sub_category" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Semua Sub Kategori --</option>
                                <?php foreach ($subCategories as $sc): ?>
                                    <option value="<?= esc($sc['sub_category']) ?>" <?= ($subCat ?? '') == $sc['sub_category'] ? 'selected' : '' ?>>
                                        <?= esc($sc['sub_category']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-3 col-lg-2">
                            <select name="year" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Semua Tahun --</option>
                                <?php foreach ($years as $yr): ?>
                                    <option value="<?= esc($yr['year']) ?>" <?= ($yearFilter ?? '') == $yr['year'] ? 'selected' : '' ?>>
                                        <?= esc($yr['year']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-5 col-lg-4">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari informasi..." value="<?= esc($search ?? '') ?>">
                                <button class="btn btn-primary-custom" type="submit"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="45%">Judul Informasi</th>
                                <th width="20%">Sub Kategori</th>
                                <th width="15%" class="text-center">Tahun</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($information)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
                                        Belum ada data informasi publik untuk kategori ini.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1 + (10 * ($pager->getCurrentPage() - 1)); ?>
                                <?php foreach ($information as $info): ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td>
                                            <div class="fw-medium text-dark">
                                                <?= esc($info['title']) ?>
                                            </div>
                                            <div class="small text-muted mt-1">
                                                Diupload: <?= date('d M Y', strtotime($info['created_at'])) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2 py-1">
                                                <?= esc($info['sub_category'] ?? '-') ?>
                                            </span>
                                        </td>
                                        <td class="text-center"><?= esc($info['year'] ?? '-') ?></td>
                                        <td class="text-center">
                                            <?php if (!empty($info['file_path'])): ?>
                                                <a href="<?= base_url($info['file_path']) ?>" target="_blank" class="btn btn-sm btn-outline-primary-custom" title="Unduh">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted small">Tidak tersedia</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($pager->getPageCount() > 1): ?>
                    <div class="mt-4 d-flex justify-content-center">
                        <?= $pager->links('default', 'bootstrap_pagination') ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
