<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<section class="py-5 bg-light min-vh-100">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="text-center mb-4" data-aos="fade-down">
                    <h6 class="text-primary fw-bold text-uppercase" style="letter-spacing: 2px;">Layanan Publik</h6>
                    <h2 class="heading-font fw-bold text-dark">Formulir Permohonan Informasi</h2>
                    <p class="text-muted">Silakan isi detail informasi yang Anda butuhkan secara lengkap dan jelas.</p>
                </div>

                <div class="card-glass border-0 shadow-sm" data-aos="fade-up" data-aos-delay="100">
                    <div class="p-4 p-md-5">
                        
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show border-0" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Terdapat kesalahan pengisian:
                                <ul class="mb-0 mt-2 text-start">
                                    <?= session()->getFlashdata('error') ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <div class="alert alert-info border-0 d-flex align-items-center mb-4">
                            <i class="bi bi-info-circle-fill fs-3 me-3 text-info"></i>
                            <div>
                                Permohonan Anda akan diproses paling lambat <strong>10 (sepuluh) hari kerja</strong> sejak diterima oleh tim PPID.
                            </div>
                        </div>

                        <form action="<?= base_url('/permohonan/store') ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            
                            <div class="mb-4">
                                <label for="subject" class="form-label fw-semibold text-dark">Subjek / Topik Permohonan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg" id="subject" name="subject" value="<?= old('subject') ?>" placeholder="Cth: Data Jumlah Penduduk Tahun 2025" required minlength="5">
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label fw-semibold text-dark">Rincian Informasi yang Dibutuhkan <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="5" placeholder="Jelaskan secara detail informasi apa saja yang Anda minta..." required minlength="10"><?= old('description') ?></textarea>
                            </div>
                            
                            <div class="mb-4">
                                <label for="purpose" class="form-label fw-semibold text-dark">Tujuan Penggunaan Informasi <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="purpose" name="purpose" rows="3" placeholder="Cth: Untuk penelitian akademik, untuk tugas akhir, dsb." required><?= old('purpose') ?></textarea>
                            </div>
                            
                            <div class="mb-5">
                                <label for="attachments" class="form-label fw-semibold text-dark">Lampiran Pendukung <span class="text-muted fw-normal">(Opsional)</span></label>
                                <input class="form-control" type="file" id="attachments" name="attachments[]" multiple>
                                <div class="form-text mt-2">
                                    <i class="bi bi-paperclip"></i> Anda dapat mengunggah file PDF, JPG, atau PNG jika diperlukan (Maks. 2MB per file).
                                </div>
                            </div>
                            
                            <hr class="mb-4 text-muted">
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary px-4">Batal</a>
                                <button type="submit" class="btn btn-primary-custom px-5 py-2 fw-semibold">
                                    <i class="bi bi-send me-2"></i> Kirim Permohonan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
