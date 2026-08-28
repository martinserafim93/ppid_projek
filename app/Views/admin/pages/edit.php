<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Halaman</h1>
    <a href="<?= base_url('admin/pages') ?>" class="btn btn-outline-secondary">
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
        <form action="<?= base_url('admin/pages/update/' . $page['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row g-4">
                <div class="col-md-8">
                    <!-- Judul -->
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold">Judul Halaman <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= old('title', $page['title']) ?>" required placeholder="Masukkan judul halaman...">
                        <div class="form-text">Slug URL saat ini: <span class="text-primary fw-medium">/<?= $page['slug'] ?></span></div>
                    </div>

                    <!-- Konten -->
                    <div class="mb-4">
                        <label for="content" class="form-label fw-semibold">Konten Halaman <span class="text-danger">*</span></label>
                        <textarea id="content" name="content"><?= old('content', $page['content']) ?></textarea>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="bg-light p-4 rounded-3 border">
                        <h5 class="mb-4 fw-bold text-dark border-bottom pb-2">Pengaturan Halaman</h5>
                        
                        <!-- Kategori -->
                        <div class="mb-4">
                            <label for="category" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="profil_kanwil" <?= old('category', $page['category']) == 'profil_kanwil' ? 'selected' : '' ?>>Profil Kanwil</option>
                                <option value="profil_ppid" <?= old('category', $page['category']) == 'profil_ppid' ? 'selected' : '' ?>>Profil PPID</option>
                                <option value="standar_layanan" <?= old('category', $page['category']) == 'standar_layanan' ? 'selected' : '' ?>>Standar Layanan</option>
                                <option value="layanan_informasi" <?= old('category', $page['category']) == 'layanan_informasi' ? 'selected' : '' ?>>Layanan Informasi</option>
                            </select>
                        </div>
                        
                        <!-- Gambar Cover -->
                        <div class="mb-4">
                            <label for="image" class="form-label fw-semibold">Gambar Utama</label>
                            
                            <?php if (!empty($page['image'])) : ?>
                                <div class="mb-2 position-relative" id="current-image-container">
                                    <img src="<?= base_url($page['image']) ?>" alt="<?= esc($page['title']) ?>" class="img-fluid rounded border w-100" style="max-height: 150px; object-fit: cover;">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input text-danger" type="checkbox" value="1" id="remove_image" name="remove_image">
                                        <label class="form-check-label text-danger" for="remove_image">
                                            Hapus gambar saat ini
                                        </label>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <input type="file" class="form-control form-control-sm" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                            <div class="form-text small">Upload baru untuk mengganti gambar saat ini. Format: JPG, PNG. Maksimal 2MB.</div>
                            
                            <div class="mt-2 text-center d-none" id="image-preview-container">
                                <span class="d-block small text-muted mb-1">Preview Gambar Baru:</span>
                                <img id="image-preview" src="#" alt="Preview" class="img-fluid rounded border" style="max-height: 150px; object-fit: cover;">
                            </div>
                        </div>

                        <!-- Lampiran File -->
                        <div class="mb-4">
                            <label for="file" class="form-label fw-semibold">Lampiran File (Opsional)</label>
                            
                            <?php if (!empty($page['file_path'])) : ?>
                                <div class="mb-2 p-2 border rounded bg-white">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-file-earmark-text text-primary fs-4 me-2"></i>
                                        <div class="text-truncate">
                                            <a href="<?= base_url($page['file_path']) ?>" target="_blank" class="text-decoration-none small">Lihat File Saat Ini</a>
                                        </div>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input text-danger" type="checkbox" value="1" id="remove_file" name="remove_file">
                                        <label class="form-check-label text-danger small" for="remove_file">
                                            Hapus lampiran saat ini
                                        </label>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <input type="file" class="form-control form-control-sm" id="file" name="file">
                            <div class="form-text small">Upload baru untuk mengganti. Format: PDF, Word, Excel. Maksimal 10MB.</div>
                        </div>

                        <!-- Urutan -->
                        <div class="mb-4">
                            <label for="sort_order" class="form-label fw-semibold">Urutan Tampil</label>
                            <input type="number" class="form-control form-control-sm" id="sort_order" name="sort_order" value="<?= old('sort_order', $page['sort_order']) ?>" min="0">
                            <div class="form-text small">Angka terkecil tampil lebih dulu (0 = default).</div>
                        </div>

                        <!-- Status Aktif -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Status Publish</label>
                            <div class="form-check form-switch form-switch-md">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" <?= old('is_active', $page['is_active']) == '1' ? 'checked' : '' ?>>
                                <label class="form-check-label ms-2" for="is_active">Aktif (Bisa diakses publik)</label>
                            </div>
                        </div>
                        
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                                <i class="bi bi-save me-1"></i> Update Halaman
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#content').summernote({
        height: 400,
        placeholder: 'Tulis konten halaman di sini...',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear', 'italic']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
    
    // Toggle current image container when a new image is selected
    $('#image').on('change', function() {
        if (this.files && this.files[0]) {
            $('#current-image-container').hide();
        } else {
            $('#current-image-container').show();
        }
    });
});

function previewImage(input) {
    var container = document.getElementById('image-preview-container');
    var preview = document.getElementById('image-preview');
    
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.classList.remove('d-none');
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '#';
        container.classList.add('d-none');
    }
}
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
