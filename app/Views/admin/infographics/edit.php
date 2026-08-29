<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Infografis</h1>
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

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="<?= base_url('admin/infographics/update/' . $infographic['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row g-4">
                <div class="col-md-7">
                    <!-- Judul Infografis -->
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold">Judul Infografis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" id="title" name="title" value="<?= old('title', $infographic['title']) ?>" required placeholder="Masukkan judul...">
                    </div>
                    
                    <!-- Keterangan/Deskripsi -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">Keterangan / Deskripsi Singkat</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Keterangan opsional..."><?= old('description', $infographic['description']) ?></textarea>
                    </div>

                    <div class="row">
                        <!-- Urutan -->
                        <div class="col-sm-6 mb-4">
                            <label for="sort_order" class="form-label fw-semibold">Urutan Tampil</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?= old('sort_order', $infographic['sort_order']) ?>" min="0">
                            <div class="form-text small">Angka terkecil tampil lebih dulu.</div>
                        </div>

                        <!-- Status Aktif -->
                        <div class="col-sm-6 mb-4">
                            <label class="form-label fw-semibold d-block">Status Publish</label>
                            <div class="form-check form-switch form-switch-lg mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" <?= old('is_active', $infographic['is_active']) == '1' ? 'checked' : '' ?>>
                                <label class="form-check-label ms-2" for="is_active">Aktif</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                            <i class="bi bi-save me-1"></i> Update Infografis
                        </button>
                    </div>
                </div>
                
                <div class="col-md-5">
                    <div class="bg-light p-4 rounded-3 border h-100 text-center d-flex flex-column">
                        <h5 class="mb-3 fw-bold text-dark border-bottom pb-2 text-start">Gambar Infografis</h5>
                        
                        <!-- Current Image Container -->
                        <div id="current-image-wrapper" class="mb-3">
                            <div class="border rounded bg-white p-2 shadow-sm position-relative">
                                <?php if (!empty($infographic['image_path'])) : ?>
                                    <img src="<?= base_url($infographic['image_path']) ?>" alt="<?= esc($infographic['title']) ?>" class="img-fluid rounded w-100 object-fit-contain" style="max-height: 250px;">
                                <?php else : ?>
                                    <div class="d-flex align-items-center justify-content-center bg-secondary bg-opacity-10 rounded w-100" style="height: 200px;">
                                        <i class="bi bi-image text-secondary fs-1"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-success shadow">Gambar Saat Ini</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-auto">
                            <label class="form-label fw-semibold small text-muted text-start d-block mt-3">Ganti Gambar (Opsional)</label>
                            
                            <div class="upload-area d-flex flex-column justify-content-center align-items-center border border-2 border-dashed border-secondary rounded-3 p-3 bg-white position-relative" id="upload-area" style="min-height: 150px; cursor: pointer;">
                                
                                <input type="file" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" id="image" name="image" accept="image/jpeg, image/png, image/webp" style="cursor: pointer; z-index: 10;">
                                
                                <div id="upload-prompt" class="text-center">
                                    <i class="bi bi-cloud-arrow-up text-primary fs-2"></i>
                                    <p class="text-muted small mb-0 mt-1">Klik atau Drag & Drop Gambar Baru<br>Maksimal ukuran: 5MB</p>
                                </div>

                                <div id="image-preview-container" class="d-none w-100 h-100 position-absolute top-0 start-0 bg-white p-2 rounded-3 z-1 d-flex justify-content-center align-items-center">
                                    <img id="image-preview" src="#" alt="Preview" class="w-100 h-100 object-fit-contain rounded">
                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 z-3" id="btn-remove-image" style="pointer-events: auto;">
                                        <i class="bi bi-x-lg"></i> Batal Ganti
                                    </button>
                                </div>
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
    const currentImageWrapper = document.getElementById('current-image-wrapper');

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
                currentImageWrapper.style.opacity = '0.3';
                
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
        currentImageWrapper.style.opacity = '1';
    });
});
</script>

<?= $this->endSection() ?>
