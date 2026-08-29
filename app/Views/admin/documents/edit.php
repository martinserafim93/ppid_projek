<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Info Dokumen</h1>
    <a href="<?= base_url('admin/documents') ?>" class="btn btn-outline-secondary">
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

<div class="row">
    <!-- Form Edit -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="m-0 font-weight-bold text-dark">Detail Informasi Dokumen</h6>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('admin/documents/update/' . $document['id']) ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <!-- Judul Dokumen -->
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold">Judul Dokumen <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" id="title" name="title" value="<?= old('title', $document['title']) ?>" required>
                    </div>
                    
                    <!-- Kategori Dokumen -->
                    <div class="mb-4">
                        <label for="category" class="form-label fw-semibold">Kategori Dokumen <span class="text-danger">*</span></label>
                        <select class="form-select form-control-lg" id="category" name="category" required>
                            <option value="umum" <?= old('category', $document['category']) == 'umum' ? 'selected' : '' ?>>Dokumen Umum</option>
                            <option value="statistik" <?= old('category', $document['category']) == 'statistik' ? 'selected' : '' ?>>Data & Statistik Tahunan</option>
                        </select>
                    </div>
                    
                    <!-- Keterangan/Deskripsi -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?= old('description', $document['description']) ?></textarea>
                    </div>

                    <!-- Ganti File (Opsional) -->
                    <div class="mb-4 p-4 bg-light rounded-3 border">
                        <label for="file" class="form-label fw-semibold">Ganti File Dokumen (Opsional)</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-white"><i class="bi bi-file-earmark-arrow-up text-primary"></i></span>
                            <input type="file" class="form-control" id="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar">
                        </div>
                        <div class="form-text small">Biarkan kosong jika tidak ingin mengganti file. Maksimal ukuran: 15MB. File lama akan otomatis terhapus jika Anda mengupload file baru.</div>
                    </div>
                    
                    <!-- Status Aktif -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold d-block">Status Akses</label>
                        <div class="form-check form-switch form-switch-md mt-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" <?= old('is_active', $document['is_active']) == '1' ? 'checked' : '' ?>>
                            <label class="form-check-label ms-2" for="is_active">
                                <span class="d-inline-block fw-medium text-dark">Publik (Bisa diunduh secara umum)</span>
                            </label>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                        <i class="bi bi-save me-1"></i> Update Informasi
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Info File Saat Ini -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="m-0 font-weight-bold text-dark">File Saat Ini</h6>
            </div>
            <div class="card-body p-0">
                <?php 
                    // Determine icon based on mime type or extension
                    $ext = strtolower(pathinfo($document['file_path'], PATHINFO_EXTENSION));
                    $icon = 'bi-file-earmark-text';
                    $iconClass = 'text-secondary';
                    $bgClass = 'bg-secondary bg-opacity-10';
                    
                    if (strpos($document['file_type'], 'pdf') !== false || $ext == 'pdf') {
                        $icon = 'bi-file-earmark-pdf-fill';
                        $iconClass = 'text-danger';
                        $bgClass = 'bg-danger bg-opacity-10';
                    } elseif (strpos($document['file_type'], 'word') !== false || in_array($ext, ['doc', 'docx'])) {
                        $icon = 'bi-file-earmark-word-fill';
                        $iconClass = 'text-primary';
                        $bgClass = 'bg-primary bg-opacity-10';
                    } elseif (strpos($document['file_type'], 'excel') !== false || in_array($ext, ['xls', 'xlsx'])) {
                        $icon = 'bi-file-earmark-excel-fill';
                        $iconClass = 'text-success';
                        $bgClass = 'bg-success bg-opacity-10';
                    } elseif (strpos($document['file_type'], 'zip') !== false || in_array($ext, ['zip', 'rar'])) {
                        $icon = 'bi-file-earmark-zip-fill';
                        $iconClass = 'text-warning';
                        $bgClass = 'bg-warning bg-opacity-10';
                    }
                    
                    // Format size
                    $bytes = $document['file_size'];
                    $size = '0 Byte';
                    if ($bytes >= 1073741824) {
                        $size = number_format($bytes / 1073741824, 2) . ' GB';
                    } elseif ($bytes >= 1048576) {
                        $size = number_format($bytes / 1048576, 2) . ' MB';
                    } elseif ($bytes >= 1024) {
                        $size = number_format($bytes / 1024, 2) . ' KB';
                    } elseif ($bytes > 1) {
                        $size = $bytes . ' Bytes';
                    } elseif ($bytes == 1) {
                        $size = $bytes . ' Byte';
                    }
                ?>
                
                <div class="text-center p-5 <?= $bgClass ?>">
                    <i class="bi <?= $icon ?> <?= $iconClass ?>" style="font-size: 5rem;"></i>
                    <h5 class="mt-3 fw-bold text-dark text-break px-3"><?= basename($document['file_path']) ?></h5>
                    <span class="badge bg-white text-dark border px-3 py-2 mt-2 shadow-sm"><?= $size ?></span>
                </div>
                
                <ul class="list-group list-group-flush mt-2">
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-muted"><i class="bi bi-filetype-raw me-2"></i>Tipe File</span>
                        <span class="fw-medium text-end text-break ms-3" style="font-size: 0.85rem;"><?= $document['file_type'] ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-muted"><i class="bi bi-clock-history me-2"></i>Diunggah</span>
                        <span class="fw-medium text-dark"><?= date('d M Y, H:i', strtotime($document['created_at'])) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-muted"><i class="bi bi-download me-2"></i>Total Unduhan</span>
                        <span class="badge bg-primary rounded-pill fs-6 px-3"><?= number_format($document['download_count']) ?></span>
                    </li>
                </ul>
                
                <div class="p-3 bg-light border-top text-center mt-auto">
                    <a href="<?= base_url('admin/documents/download/' . $document['id']) ?>" class="btn btn-outline-primary w-100 fw-bold">
                        <i class="bi bi-cloud-download me-2"></i> Download File Ini
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-switch-md .form-check-input {
    width: 2.5em;
    height: 1.25em;
}
</style>

<?= $this->endSection() ?>
