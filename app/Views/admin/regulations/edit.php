<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1 text-gray-800 fw-bold">Edit Regulasi</h1>
        <p class="text-muted mb-0">Perbarui data regulasi & dasar hukum PPID.</p>
    </div>
    <a href="<?= base_url('admin/regulations') ?>" class="btn btn-light border shadow-sm rounded-pill px-3 hover-lift">
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

<form action="<?= base_url('admin/regulations/update/' . $regulation['id']) ?>" method="post" enctype="multipart/form-data">
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
                        <input type="text" class="form-control form-control-lg bg-light border-0" id="title" name="title" value="<?= old('title', $regulation['title']) ?>" required placeholder="Masukkan judul regulasi">
                        <div class="form-text small mt-2">
                            <i class="bi bi-link-45deg"></i> Pratinjau URL: <span class="text-primary" id="slug-preview">/regulasi/<?= esc($regulation['slug'] ?? '...') ?></span>
                        </div>
                    </div>
                    
                    <div class="row g-3 mb-4">
                        <!-- Tipe -->
                        <div class="col-md-4">
                            <label for="type" class="form-label fw-semibold text-dark">Kategori Regulasi <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg bg-light border-0" id="type" name="type" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php if (!empty($categories)) : ?>
                                    <?php foreach ($categories as $cat) : ?>
                                        <option value="<?= esc($cat['slug']) ?>" <?= old('type', $regulation['type']) == $cat['slug'] ? 'selected' : '' ?>>
                                            <?= esc($cat['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <?php if (empty($categories)) : ?>
                                <div class="form-text small mt-2 text-danger">
                                    <i class="bi bi-exclamation-triangle me-1"></i> Belum ada kategori regulasi. <br>
                                    <a href="<?= base_url('admin/categories/regulations/create') ?>" class="text-danger fw-semibold text-decoration-underline">Buat Kategori Baru</a>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Nomor -->
                        <div class="col-md-4">
                            <label for="number" class="form-label fw-semibold text-dark">Nomor</label>
                            <input type="text" class="form-control form-control-lg bg-light border-0" id="number" name="number" value="<?= old('number', $regulation['number']) ?>" placeholder="Contoh: 14">
                        </div>
                        
                        <!-- Tahun -->
                        <div class="col-md-4">
                            <label for="year" class="form-label fw-semibold text-dark">Tahun</label>
                            <input type="number" class="form-control form-control-lg bg-light border-0" id="year" name="year" value="<?= old('year', $regulation['year']) ?>" min="1945" max="<?= date('Y') + 1 ?>" placeholder="Contoh: 2008">
                        </div>
                    </div>

                    <!-- Keterangan/Deskripsi -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold text-dark">Keterangan / Deskripsi Singkat</label>
                        <textarea class="form-control bg-light border-0" id="description" name="description" rows="5" placeholder="Masukkan keterangan tambahan jika ada..."><?= old('description', $regulation['description']) ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar Area (Settings) -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-light">
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="fw-bold mb-4 pb-2 border-bottom border-secondary border-opacity-25 text-dark">Pengaturan Dokumen</h5>
                    
                    <!-- Lampiran File -->
                    <div class="mb-4">
                        <label for="file" class="form-label fw-semibold text-dark">File PDF Regulasi</label>
                        
                        <?php if (!empty($regulation['file_path'])) : ?>
                            <div class="mb-3 p-3 border rounded bg-white shadow-sm hover-lift">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bg-danger bg-opacity-10 p-2 rounded me-3">
                                        <i class="bi bi-file-earmark-pdf-fill text-danger fs-3"></i>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <div class="fw-medium text-dark text-truncate" title="Dokumen Regulasi">
                                            Dokumen Saat Ini
                                        </div>
                                        <a href="<?= base_url($regulation['file_path']) ?>" target="_blank" class="text-decoration-none small">
                                            Lihat PDF <i class="bi bi-box-arrow-up-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="form-check mt-3 pt-2 border-top">
                                    <input class="form-check-input text-danger" type="checkbox" value="1" id="remove_file" name="remove_file">
                                    <label class="form-check-label text-danger fw-medium small" for="remove_file">
                                        Hapus file PDF ini
                                    </label>
                                </div>
                            </div>
                            
                            <label for="file" class="form-label fw-semibold small text-muted mt-3">Ganti / Upload PDF Baru</label>
                        <?php else : ?>
                            <div class="alert alert-secondary py-2 small mb-3 border-0 bg-white shadow-sm">
                                <i class="bi bi-info-circle me-1"></i> Belum ada file PDF yang diupload.
                            </div>
                        <?php endif; ?>

                        <div class="input-group input-group-lg bg-white rounded-3 overflow-hidden shadow-sm">
                            <span class="input-group-text bg-white border-0 text-muted"><i class="bi bi-cloud-arrow-up"></i></span>
                            <input type="file" class="form-control border-0" id="file" name="file" accept=".pdf">
                        </div>
                        <div class="form-text small mt-2"><i class="bi bi-info-circle me-1"></i>Hanya format <strong>PDF</strong> (Maks. 10MB). Upload baru otomatis mengganti file lama.</div>
                    </div>

                    <!-- Urutan -->
                    <div class="mb-4">
                        <label for="sort_order" class="form-label fw-semibold text-dark">Urutan Tampil</label>
                        <input type="number" class="form-control form-control-lg border-0 shadow-none" id="sort_order" name="sort_order" value="<?= old('sort_order', $regulation['sort_order']) ?>" min="0">
                        <div class="form-text small"><i class="bi bi-info-circle me-1"></i>Angka terkecil tampil lebih dulu (0 = default).</div>
                    </div>

                    <!-- Status Aktif -->
                    <div class="mb-4 p-3 bg-white rounded-3 shadow-sm border border-light">
                        <div class="form-check form-switch form-switch-md mb-0 d-flex align-items-center">
                            <input class="form-check-input mt-0 me-3 shadow-none" type="checkbox" role="switch" id="is_active" name="is_active" value="1" <?= old('is_active', $regulation['is_active']) == '1' ? 'checked' : '' ?> style="cursor: pointer;">
                            <label class="form-check-label fw-semibold text-dark" for="is_active" style="cursor: pointer;">
                                Publish Regulasi
                                <span class="d-block fw-normal text-muted small mt-1">Tampilkan regulasi ini di website publik</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="mt-auto pt-4">
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm rounded-pill d-flex align-items-center justify-content-center hover-lift">
                            <i class="bi bi-save me-2 fs-5"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const titleInput = document.getElementById('title');
    const slugPreview = document.getElementById('slug-preview');

    if (titleInput && slugPreview) {
        titleInput.addEventListener('input', function() {
            let slug = this.value.toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
            
            slugPreview.textContent = slug ? '/regulasi/' + slug : '/regulasi/...';
        });
    }
});
</script>

<?= $this->endSection() ?>
