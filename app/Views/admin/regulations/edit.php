<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Regulasi</h1>
    <a href="<?= base_url('admin/regulations') ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<?php if (session()->getFlashdata('errors')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Terjadi Kesalahan:</strong>
        <ul class="mb-0 mt-2">
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="<?= base_url('admin/regulations/update/' . $regulation['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row g-4">
                <div class="col-md-8">
                    <!-- Judul/Tentang -->
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold">Judul / Tentang Regulasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= old('title', $regulation['title']) ?>" required placeholder="Contoh: Keterbukaan Informasi Publik">
                    </div>
                    
                    <div class="row mb-4">
                        <!-- Tipe -->
                        <div class="col-md-4">
                            <label for="type" class="form-label fw-semibold">Kategori Regulasi <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php if (!empty($categories)) : ?>
                                    <?php foreach ($categories as $cat) : ?>
                                        <option value="<?= esc($cat['slug']) ?>" <?= old('type', $regulation['type']) == $cat['slug'] ? 'selected' : '' ?>>
                                            <?= esc($cat['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <!-- Nomor -->
                        <div class="col-md-4">
                            <label for="number" class="form-label fw-semibold">Nomor</label>
                            <input type="text" class="form-control" id="number" name="number" value="<?= old('number', $regulation['number']) ?>" placeholder="Contoh: 14">
                        </div>
                        
                        <!-- Tahun -->
                        <div class="col-md-4">
                            <label for="year" class="form-label fw-semibold">Tahun</label>
                            <input type="number" class="form-control" id="year" name="year" value="<?= old('year', $regulation['year']) ?>" min="1945" max="<?= date('Y') + 1 ?>" placeholder="Contoh: 2008">
                        </div>
                    </div>

                    <!-- Keterangan/Deskripsi -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">Keterangan / Deskripsi Singkat</label>
                        <textarea class="form-control" id="description" name="description" rows="5" placeholder="Masukkan keterangan tambahan jika ada..."><?= old('description', $regulation['description']) ?></textarea>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="bg-light p-4 rounded-3 border h-100">
                        <h5 class="mb-4 fw-bold text-dark border-bottom pb-2">Dokumen & Publish</h5>
                        
                        <!-- Lampiran File -->
                        <div class="mb-4">
                            <label for="file" class="form-label fw-semibold">File PDF Saat Ini</label>
                            
                            <?php if (!empty($regulation['file_path'])) : ?>
                                <div class="mb-3 p-3 border rounded bg-white border-danger border-opacity-50 shadow-sm">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-file-earmark-pdf-fill text-danger fs-2 me-3"></i>
                                        <div>
                                            <div class="fw-medium text-dark text-truncate" style="max-width: 200px;">
                                                Dokumen Regulasi
                                            </div>
                                            <a href="<?= base_url($regulation['file_path']) ?>" target="_blank" class="text-decoration-none small">
                                                Lihat / Download PDF <i class="bi bi-box-arrow-up-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <hr class="my-2 text-muted">
                                    <div class="form-check">
                                        <input class="form-check-input text-danger" type="checkbox" value="1" id="remove_file" name="remove_file">
                                        <label class="form-check-label text-danger fw-medium" for="remove_file">
                                            Hapus file PDF ini
                                        </label>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="alert alert-secondary py-2 small mb-3">Belum ada file PDF yang diupload.</div>
                            <?php endif; ?>
                            
                            <label for="file" class="form-label fw-semibold small text-muted">Ganti / Upload PDF Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-upload"></i></span>
                                <input type="file" class="form-control" id="file" name="file" accept=".pdf">
                            </div>
                            <div class="form-text small mt-1">Hanya format <strong>PDF</strong> (Maks. 10MB). Upload baru akan otomatis mengganti file lama.</div>
                        </div>

                        <!-- Urutan -->
                        <div class="mb-4">
                            <label for="sort_order" class="form-label fw-semibold">Urutan Tampil</label>
                            <input type="number" class="form-control form-control-sm" id="sort_order" name="sort_order" value="<?= old('sort_order', $regulation['sort_order']) ?>" min="0">
                            <div class="form-text small">Angka terkecil tampil lebih dulu (0 = default).</div>
                        </div>

                        <!-- Status Aktif -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Status Publish</label>
                            <div class="form-check form-switch form-switch-md">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" <?= old('is_active', $regulation['is_active']) == '1' ? 'checked' : '' ?>>
                                <label class="form-check-label ms-2" for="is_active">Aktif (Tampil di website)</label>
                            </div>
                        </div>
                        
                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                                <i class="bi bi-save me-1"></i> Update Regulasi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
