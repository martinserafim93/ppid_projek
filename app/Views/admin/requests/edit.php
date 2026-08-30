<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Edit Permohonan Informasi</h2>
    <a href="<?= base_url('admin/requests') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h6 class="m-0 fw-bold text-warning"><i class="bi bi-pencil-square me-2"></i>Edit Data Permohonan - <?= esc($request['ticket_number']) ?></h6>
            </div>
            <div class="card-body p-4">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('admin/requests/update_data/' . $request['slug']) ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Pemohon <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-select border-0 bg-light" required>
                            <option value="">-- Pilih Pemohon --</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user['id'] ?>" <?= (old('user_id') ?? $request['user_id']) == $user['id'] ? 'selected' : '' ?>>
                                    <?= esc($user['name']) ?> (<?= esc($user['email']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Rincian Informasi yang Dibutuhkan <span class="text-danger">*</span></label>
                        <textarea name="subject" class="form-control border-0 bg-light" rows="3" required><?= esc(old('subject') ?? $request['subject']) ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Alasan Permintaan Informasi <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control border-0 bg-light" rows="4" required><?= esc(old('description') ?? $request['description']) ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">Tujuan Penggunaan Informasi <span class="text-danger">*</span></label>
                        <textarea name="purpose" class="form-control border-0 bg-light" rows="3" required><?= esc(old('purpose') ?? $request['purpose']) ?></textarea>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('admin/requests') ?>" class="btn btn-light rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-warning rounded-pill px-4 fw-bold text-dark hover-lift">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4 bg-warning bg-opacity-10">
            <div class="card-body p-4">
                <h6 class="fw-bold text-warning text-darken-2 mb-3"><i class="bi bi-exclamation-triangle-fill me-2"></i>Perhatian</h6>
                <p class="small text-muted mb-2">
                    Mengedit data permohonan idealnya hanya dilakukan untuk memperbaiki kesalahan penulisan (*typo*) atau menyesuaikan data yang tidak lengkap atas persetujuan pemohon.
                </p>
                <p class="small text-muted mb-0">
                    Perubahan status permohonan (seperti menyetujui atau menolak) tetap dilakukan melalui halaman <strong>Detail</strong>.
                </p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
