<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 fw-bold">Tambah Regulasi</h1>
        <p class="text-muted mb-0">Tambahkan data dokumen regulasi baru ke dalam sistem.</p>
    </div>
    <a href="<?= base_url('admin/regulations') ?>" class="btn btn-light border shadow-sm rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<?php if (session()->getFlashdata('errors')) : ?>
    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4" role="alert">
        <div class="d-flex align-items-center mb-2">
            <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
            <strong class="mb-0">Terjadi Kesalahan!</strong>
        </div>
        <ul class="mb-0 ps-4">
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center" role="alert">
        <i class="bi bi-exclamation-circle-fill fs-5 me-2"></i>
        <div class="flex-grow-1"><?= session()->getFlashdata('error') ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<form action="<?= base_url('admin/regulations/store') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    
    <div class="row g-4">
        <!-- Main Form Area -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 p-xl-5">
                    <h5 class="fw-bold mb-4 pb-2 border-bottom">Informasi Dasar</h5>
                    
                    <!-- Judul/Tentang -->
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold text-dark">Judul / Tentang Regulasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg bg-light border-0" id="title" name="title" value="<?= old('title') ?>" required placeholder="Contoh: Keterbukaan Informasi Publik">
                    </div>
                    
                    <div class="row g-3 mb-4">
                        <!-- Tipe -->
                        <div class="col-md-4">
                            <label for="type" class="form-label fw-semibold text-dark">Kategori Regulasi <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg bg-light border-0" id="type" name="type" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php if (!empty($categories)) : ?>
                                    <?php foreach ($categories as $cat) : ?>
                                        <option value="<?= esc($cat['slug']) ?>" <?= old('type') == $cat['slug'] ? 'selected' : '' ?>>
                                            <?= esc($cat['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <!-- Nomor -->
                        <div class="col-md-4">
                            <label for="number" class="form-label fw-semibold text-dark">Nomor</label>
                            <input type="text" class="form-control form-control-lg bg-light border-0" id="number" name="number" value="<?= old('number') ?>" placeholder="Contoh: 14">
                        </div>
                        
                        <!-- Tahun -->
                        <div class="col-md-4">
                            <label for="year" class="form-label fw-semibold text-dark">Tahun</label>
                            <input type="number" class="form-control form-control-lg bg-light border-0" id="year" name="year" value="<?= old('year') ?>" min="1945" max="<?= date('Y') + 1 ?>" placeholder="Contoh: 2008">
                        </div>
                    </div>

                    <!-- Keterangan/Deskripsi -->
                    <div class="mb-2">
                        <label for="description" class="form-label fw-semibold text-dark">Keterangan Tambahan</label>
                        <textarea class="form-control bg-light border-0" id="description" name="description" rows="5" placeholder="Masukkan keterangan tambahan atau catatan jika ada..."><?= old('description') ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar Area -->
        <div class="col-lg-4">
            <div class="card bg-light border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 p-xl-5 d-flex flex-column">
                    <h5 class="fw-bold mb-4 pb-2 border-bottom d-flex align-items-center">
                        <i class="bi bi-file-earmark-arrow-up text-primary me-2"></i> Dokumen & Publish
                    </h5>
                    
                    <!-- Lampiran File -->
                    <div class="mb-4">
                        <label for="file" class="form-label fw-semibold text-dark">Upload File PDF</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-danger text-white border-0"><i class="bi bi-filetype-pdf"></i></span>
                            <input type="file" class="form-control border-0 shadow-none" id="file" name="file" accept=".pdf">
                        </div>
                        <div class="form-text small mt-2"><i class="bi bi-info-circle me-1"></i>Hanya menerima format <strong>PDF</strong>. Maksimal 10MB.</div>
                    </div>

                    <!-- Urutan -->
                    <div class="mb-4">
                        <label for="sort_order" class="form-label fw-semibold text-dark">Urutan Tampil</label>
                        <input type="number" class="form-control form-control-lg border-0 shadow-none" id="sort_order" name="sort_order" value="<?= old('sort_order', '0') ?>" min="0">
                        <div class="form-text small"><i class="bi bi-info-circle me-1"></i>Angka terkecil tampil lebih dulu (0 = default).</div>
                    </div>

                    <!-- Status Aktif -->
                    <div class="mb-4 p-3 bg-white rounded-3 shadow-sm border border-light">
                        <div class="form-check form-switch form-switch-md mb-0 d-flex align-items-center">
                            <input class="form-check-input mt-0 me-3 shadow-none" type="checkbox" role="switch" id="is_active" name="is_active" value="1" <?= old('is_active', '1') == '1' ? 'checked' : '' ?> style="width: 2.5em; height: 1.25em; cursor: pointer;">
                            <label class="form-check-label fw-semibold text-dark" for="is_active" style="cursor: pointer;">
                                Publish Regulasi
                                <span class="d-block fw-normal text-muted small mt-1">Tampilkan regulasi ini di website publik</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="mt-auto pt-4">
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm rounded-pill d-flex align-items-center justify-content-center">
                            <i class="bi bi-cloud-upload-fill me-2 fs-5"></i> Simpan & Publish
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?= $this->endSection() ?>
