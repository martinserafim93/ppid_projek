<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Informasi Publik</h1>
    <a href="<?= base_url('admin/public-informations?category=' . $information['category']) ?>" class="btn btn-outline-secondary">
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
        <form action="<?= base_url('admin/public-informations/update/' . $information['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row g-4">
                <div class="col-md-8">
                    <!-- Judul Informasi -->
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold">Judul Informasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= old('title', $information['title']) ?>" required placeholder="Masukkan judul informasi publik...">
                    </div>
                    
                    <div class="row mb-4">
                        <!-- Kategori Utama -->
                        <div class="col-md-6">
                            <label for="category" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php if (!empty($categories)) : ?>
                                    <?php foreach ($categories as $cat) : ?>
                                        <option value="<?= esc($cat['slug']) ?>" <?= old('category', $information['category']) == $cat['slug'] ? 'selected' : '' ?>>
                                            <?= esc($cat['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <!-- Sub Kategori -->
                        <div class="col-md-6">
                            <label for="sub_category" class="form-label fw-semibold">Sub Kategori (Opsional)</label>
                            <input type="text" class="form-control" id="sub_category" name="sub_category" value="<?= old('sub_category', $information['sub_category']) ?>" placeholder="Contoh: Laporan Keuangan">
                        </div>
                    </div>

                    <!-- Keterangan/Deskripsi -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">Keterangan Tambahan / Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Keterangan singkat mengenai dokumen/informasi ini..."><?= old('description', $information['description']) ?></textarea>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="bg-light p-4 rounded-3 border h-100">
                        <h5 class="mb-4 fw-bold text-dark border-bottom pb-2">Dokumen & Publish</h5>
                        
                        <!-- Lampiran File -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Dokumen/Lampiran Saat Ini</label>
                            
                            <?php if (!empty($information['file_path'])) : ?>
                                <div class="mb-3 p-3 border rounded bg-white shadow-sm">
                                    <div class="d-flex align-items-center mb-2">
                                        <?php 
                                            // Determine icon based on extension
                                            $ext = strtolower(pathinfo($information['file_path'], PATHINFO_EXTENSION));
                                            $icon = 'bi-file-earmark-text';
                                            $iconColor = 'text-secondary';
                                            
                                            if (in_array($ext, ['pdf'])) {
                                                $icon = 'bi-file-earmark-pdf-fill';
                                                $iconColor = 'text-danger';
                                            } elseif (in_array($ext, ['doc', 'docx'])) {
                                                $icon = 'bi-file-earmark-word-fill';
                                                $iconColor = 'text-primary';
                                            } elseif (in_array($ext, ['xls', 'xlsx'])) {
                                                $icon = 'bi-file-earmark-excel-fill';
                                                $iconColor = 'text-success';
                                            } elseif (in_array($ext, ['zip', 'rar'])) {
                                                $icon = 'bi-file-earmark-zip-fill';
                                                $iconColor = 'text-warning';
                                            }
                                        ?>
                                        <i class="bi <?= $icon ?> <?= $iconColor ?> fs-2 me-3"></i>
                                        <div>
                                            <a href="<?= base_url($information['file_path']) ?>" target="_blank" class="text-decoration-none small fw-medium">
                                                Lihat / Download File <i class="bi bi-box-arrow-up-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <hr class="my-2 text-muted">
                                    <div class="form-check">
                                        <input class="form-check-input text-danger" type="checkbox" value="1" id="remove_file" name="remove_file">
                                        <label class="form-check-label text-danger fw-medium" for="remove_file">
                                            Hapus file ini
                                        </label>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="alert alert-secondary py-2 small mb-3">Belum ada file yang diupload.</div>
                            <?php endif; ?>
                            
                            <label for="file" class="form-label fw-semibold small text-muted mt-2">Ganti / Upload File Baru</label>
                            <input type="file" class="form-control" id="file" name="file">
                            <div class="form-text small mt-1">Format: PDF, Word, Excel, ZIP. Maks. 10MB. Upload baru akan menimpa file lama.</div>
                        </div>
                        
                        <!-- Tahun -->
                        <div class="mb-4">
                            <label for="year" class="form-label fw-semibold">Tahun Dokumen (Opsional)</label>
                            <input type="number" class="form-control" id="year" name="year" value="<?= old('year', $information['year']) ?>" min="2000" max="<?= date('Y') + 1 ?>">
                        </div>

                        <!-- Urutan -->
                        <div class="mb-4">
                            <label for="sort_order" class="form-label fw-semibold">Urutan Tampil</label>
                            <input type="number" class="form-control form-control-sm" id="sort_order" name="sort_order" value="<?= old('sort_order', $information['sort_order']) ?>" min="0">
                            <div class="form-text small">Angka terkecil tampil lebih dulu.</div>
                        </div>

                        <!-- Status Aktif -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Status Publish</label>
                            <div class="form-check form-switch form-switch-md">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" <?= old('is_active', $information['is_active']) == '1' ? 'checked' : '' ?>>
                                <label class="form-check-label ms-2" for="is_active">Aktif (Tampil di publik)</label>
                            </div>
                        </div>
                        
                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                                <i class="bi bi-save me-1"></i> Update Informasi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
