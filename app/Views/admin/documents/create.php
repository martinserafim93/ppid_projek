<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Upload Dokumen Baru</h1>
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

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form action="<?= base_url('admin/documents/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row g-4">
                <div class="col-md-7">
                    <!-- File Upload Area -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Pilih File Dokumen <span class="text-danger">*</span></label>
                        
                        <div class="upload-area d-flex flex-column justify-content-center align-items-center border border-2 border-dashed border-primary rounded-3 p-5 bg-light position-relative text-center" id="upload-area" style="cursor: pointer; transition: all 0.3s;">
                            
                            <input type="file" class="position-absolute top-0 start-0 w-100 h-100 opacity-0" id="file" name="file" required style="cursor: pointer; z-index: 10;">
                            
                            <div id="upload-prompt">
                                <i class="bi bi-cloud-arrow-up text-primary" style="font-size: 3rem;"></i>
                                <h5 class="mt-3 text-dark fw-bold">Klik atau Drag & Drop File</h5>
                                <p class="text-muted small mb-0">Format: PDF, DOC/X, XLS/X, PPT/X, ZIP/RAR<br>Maksimal ukuran: 15MB</p>
                            </div>

                            <div id="file-info-container" class="d-none w-100 z-1 px-4">
                                <div class="d-flex align-items-center justify-content-center p-3 bg-white rounded shadow-sm border border-success">
                                    <i id="file-icon" class="bi bi-file-earmark-check-fill text-success fs-1 me-3"></i>
                                    <div class="text-start overflow-hidden">
                                        <h6 id="file-name-display" class="mb-1 text-truncate fw-bold text-dark" style="max-width: 250px;">filename.ext</h6>
                                        <div class="small text-muted d-flex align-items-center gap-2">
                                            <span id="file-size-display" class="badge bg-light text-dark border">0 KB</span>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger ms-auto z-3" id="btn-remove-file" style="pointer-events: auto;">
                                        <i class="bi bi-x-lg"></i> Batal
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-5">
                    <div class="bg-light p-4 rounded-3 border h-100">
                        <h5 class="mb-4 fw-bold text-dark border-bottom pb-2">Informasi Dokumen</h5>
                        
                        <!-- Judul Dokumen -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold">Judul Dokumen <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" value="<?= old('title') ?>" required placeholder="Masukkan judul dokumen...">
                            <div class="form-text small" id="title-hint">Akan terisi otomatis jika file dipilih, tapi bisa diedit.</div>
                        </div>
                        
                        <!-- Keterangan/Deskripsi -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">Deskripsi (Opsional)</label>
                            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Tambahkan catatan atau deskripsi singkat..."><?= old('description') ?></textarea>
                        </div>

                        <!-- Status Aktif -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold d-block">Status Akses</label>
                            <div class="form-check form-switch form-switch-md mt-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" <?= old('is_active', '1') == '1' ? 'checked' : '' ?>>
                                <label class="form-check-label ms-2" for="is_active">
                                    <span class="d-block fw-medium text-dark">Publik (Bisa diunduh)</span>
                                    <span class="small text-muted">Jika nonaktif, hanya admin yang bisa melihat/unduh.</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-semibold" id="btn-submit" disabled>
                                <i class="bi bi-cloud-arrow-up me-1"></i> Upload & Simpan
                            </button>
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
    background-color: #e9ecef !important;
}
.form-switch-md .form-check-input {
    width: 2.5em;
    height: 1.25em;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file');
    const uploadPrompt = document.getElementById('upload-prompt');
    const fileInfoContainer = document.getElementById('file-info-container');
    const fileNameDisplay = document.getElementById('file-name-display');
    const fileSizeDisplay = document.getElementById('file-size-display');
    const fileIcon = document.getElementById('file-icon');
    const removeBtn = document.getElementById('btn-remove-file');
    const uploadArea = document.getElementById('upload-area');
    const titleInput = document.getElementById('title');
    const submitBtn = document.getElementById('btn-submit');

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
            uploadArea.classList.add('bg-white');
            uploadArea.classList.remove('bg-light');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, () => {
            uploadArea.classList.remove('bg-white');
            uploadArea.classList.add('bg-light');
        }, false);
    });

    // Handle file selection
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            
            // Validate file size (15MB)
            if (file.size > 15 * 1024 * 1024) {
                Swal.fire('Error', 'Ukuran file terlalu besar. Maksimal 15MB.', 'error');
                resetUpload();
                return;
            }

            // Format size
            let sizeStr = '0 Byte';
            if (file.size >= 1048576) {
                sizeStr = (file.size / 1048576).toFixed(2) + ' MB';
            } else if (file.size >= 1024) {
                sizeStr = (file.size / 1024).toFixed(2) + ' KB';
            } else {
                sizeStr = file.size + ' Bytes';
            }

            // Set icon based on extension
            const ext = file.name.split('.').pop().toLowerCase();
            let iconClass = 'bi-file-earmark-check-fill text-success';
            
            if (['pdf'].includes(ext)) {
                iconClass = 'bi-file-earmark-pdf-fill text-danger';
            } else if (['doc', 'docx'].includes(ext)) {
                iconClass = 'bi-file-earmark-word-fill text-primary';
            } else if (['xls', 'xlsx'].includes(ext)) {
                iconClass = 'bi-file-earmark-excel-fill text-success';
            } else if (['zip', 'rar'].includes(ext)) {
                iconClass = 'bi-file-earmark-zip-fill text-warning';
            } else if (['ppt', 'pptx'].includes(ext)) {
                iconClass = 'bi-file-earmark-ppt-fill text-warning';
            }
            
            fileIcon.className = `bi ${iconClass} fs-1 me-3`;

            // Display info
            fileNameDisplay.textContent = file.name;
            fileSizeDisplay.textContent = sizeStr;
            
            // Auto-fill title if empty
            if (titleInput.value.trim() === '') {
                // Remove extension and replace dashes/underscores with space
                let niceName = file.name.replace(/\.[^/.]+$/, "").replace(/[-_]/g, " ");
                // Capitalize first letter of words
                niceName = niceName.replace(/\b\w/g, l => l.toUpperCase());
                titleInput.value = niceName;
            }

            uploadPrompt.classList.add('d-none');
            fileInfoContainer.classList.remove('d-none');
            uploadArea.classList.replace('border-dashed', 'border-solid');
            
            submitBtn.removeAttribute('disabled');
            removeBtn.style.zIndex = '20';
        }
    });

    function resetUpload() {
        fileInput.value = '';
        uploadPrompt.classList.remove('d-none');
        fileInfoContainer.classList.add('d-none');
        uploadArea.classList.replace('border-solid', 'border-dashed');
        submitBtn.setAttribute('disabled', 'disabled');
    }

    // Handle remove file
    removeBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        resetUpload();
    });
});
</script>

<?= $this->endSection() ?>
