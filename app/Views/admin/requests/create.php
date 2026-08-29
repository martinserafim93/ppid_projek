<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Tambah Permohonan Informasi</h2>
    <a href="<?= base_url('admin/requests') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="m-0 fw-bold text-primary"><i class="bi bi-file-earmark-plus me-2"></i>Form Permohonan Baru</h6>
            </div>
            <div class="card-body p-4">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('admin/requests/store') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Pemohon <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-select border-0 bg-light" required>
                            <option value="">-- Pilih Pemohon --</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user['id'] ?>" <?= old('user_id') == $user['id'] ? 'selected' : '' ?>>
                                    <?= esc($user['name']) ?> (<?= esc($user['email']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text text-muted small">Jika pemohon belum ada, silakan daftarkan terlebih dahulu di menu Kelola Pengguna.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Rincian Informasi yang Dibutuhkan <span class="text-danger">*</span></label>
                        <textarea name="subject" class="form-control border-0 bg-light" rows="3" required placeholder="Contoh: Salinan Dokumen DPA Tahun 2024"><?= old('subject') ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Alasan Permintaan Informasi <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control border-0 bg-light" rows="4" required placeholder="Jelaskan alasan atau latar belakang permintaan informasi ini..."><?= old('description') ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Tujuan Penggunaan Informasi <span class="text-danger">*</span></label>
                        <textarea name="purpose" class="form-control border-0 bg-light" rows="3" required placeholder="Contoh: Untuk penelitian akademis di Universitas X..."><?= old('purpose') ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Lampiran Dokumen / Identitas (Opsional)</label>
                        <input type="file" name="files[]" class="form-control border-0 bg-light" multiple>
                        <div class="form-text text-muted small">Dapat mengunggah lebih dari satu file (KTP/Surat Kuasa/dll). Maks 2MB per file.</div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-light rounded-pill px-4">Reset</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">
                            <i class="bi bi-save me-1"></i> Simpan Permohonan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4 bg-primary bg-opacity-10">
            <div class="card-body p-4">
                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-info-circle-fill me-2"></i>Informasi</h6>
                <p class="small text-muted mb-2">
                    Gunakan formulir ini untuk mencatat permohonan informasi yang masuk melalui saluran offline (datang langsung, surat menyurat, dsb).
                </p>
                <p class="small text-muted mb-0">
                    Pastikan identitas pemohon sudah tercatat dalam sistem agar pemohon dapat melacak status permohonan secara mandiri melalui portal publik.
                </p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
