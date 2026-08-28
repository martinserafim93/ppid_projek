<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Infografis</h1>
    <a href="<?= base_url('admin/infographics') ?>" class="btn btn-outline-secondary">
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

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="<?= base_url('admin/infographics/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row g-4">
                <div class="col-md-7">
                    <!-- Judul Infografis -->
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold">Judul Infografis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" id="title" name="title" value="<?= old('title') ?>" required placeholder="Masukkan judul...">
                    </div>
                    
                    <!-- Keterangan/Deskripsi -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">Keterangan / Deskripsi Singkat</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Keterangan opsional..."><?= old('description') ?></textarea>
                    </div>

                    <div class="row">
                        <!-- Urutan -->
                        <div class="col-sm-6 mb-4">
                            <label for="sort_order" class="form-label fw-semibold">Urutan Tampil</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?= old('sort_order', '0') ?>" min="0">
                            <div class="form-text small">Angka terkecil tampil lebih dulu.</div>
                        </div>

                        <!-- Status Aktif -->
                        <div class="col-sm-6 mb-4">
                            <label class="form-label fw-semibold d-block">Status Publish</label>
                            <div class="form-check form-switch form-switch-lg mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" <?= old('is_active', '1') == '1' ? 'checked' : '' ?>>
                                <label class="form-check-label ms-2" for="is_active">Aktif</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                            <i class="bi bi-save me-1"></i> Simpan Infografis
                        </button>
                    </div>
                </div>
                
                <div class="col-md-5">
                    <div class="bg-light p-4 rounded-3 border h-100 text-center d-flex flex-column">
                        <h5 class="mb-3 fw-bold text-dark border-bottom pb-2 text-start">Gambar Infografis <span class="text-danger">*</span></h5>
                        
                        <div class="upload-area flex-grow-1 d-flex flex-column justify-content-center align-items-center border border-2 border-dashed border-secondary rounded-3 p-4 bg-white position-relative" id="upload-area" style="min-height: 300px; cursor: pointer;">
                            
                            <input type="file" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" id="image" name="image" accept="image/jpeg, image/png, image/webp" required style="cursor: pointer; z-index: 10;">
                            
                            <div id="upload-prompt" class="text-center">
                                <i class="bi bi-cloud-arrow-up text-primary" style="font-size: 4rem;"></i>
                                <h5 class="mt-3 text-dark">Klik atau Drag & Drop Gambar</h5>
                                <p class="text-muted small mb-0">Format: JPG, PNG, WEBP<br>Maksimal ukuran: 5MB</p>
                            </div>

                            <div id="image-preview-container" class="d-none w-100 h-100 position-absolute top-0 start-0 bg-white p-2 rounded-3 z-1">
                                <img id="image-preview" src="#" alt="Preview" class="w-100 h-100 object-fit-contain rounded">
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-3 z-3" id="btn-remove-image" style="pointer-events: auto;">
                                    <i class="bi bi-x-lg"></i> Ganti
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.border-dashed {
    border-style: dashed !important;
}
.upload-area:hover {
    background-color: #f8f9fa !important;
    border-color: var(--primary-color, #1B5E20) !important;
}
.form-switch-lg .form-check-input {
    width: 3em;
    height: 1.5em;
}
.form-switch-lg .form-check-label {
    padding-top: 0.25rem;
    font-size: 1.1rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('image');
    const uploadPrompt = document.getElementById('upload-prompt');
    const previewContainer = document.getElementById('image-preview-container');
    const previewImage = document.getElementById('image-preview');
    const removeBtn = document.getElementById('btn-remove-image');
    const uploadArea = document.getElementById('upload-area');

    // Drag and drop styles
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults (e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, () => {
            uploadArea.classList.add('border-primary', 'bg-light');
            uploadArea.classList.remove('border-secondary');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, () => {
            uploadArea.classList.remove('border-primary', 'bg-light');
            uploadArea.classList.add('border-secondary');
        }, false);
    });

    // Handle file selection
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            
            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                Swal.fire('Error', 'Ukuran file terlalu besar. Maksimal 5MB.', 'error');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                uploadPrompt.classList.add('d-none');
                previewContainer.classList.remove('d-none');
                
                // Bring remove button to front above the file input
                removeBtn.style.zIndex = '20';
            }
            
            reader.readAsDataURL(file);
        }
    });

    // Handle remove image
    removeBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        fileInput.value = '';
        previewImage.src = '#';
        uploadPrompt.classList.remove('d-none');
        previewContainer.classList.add('d-none');
    });
});
</script>

<?= $this->endSection() ?>
