<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<section class="py-5 bg-light min-vh-100 d-flex align-items-center">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 text-center">
                
                <div class="card-glass border-0 shadow-sm" data-aos="zoom-in" data-aos-duration="500">
                    <div class="p-5">
                        <div class="mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 rounded-circle mb-3" style="width: 100px; height: 100px;">
                                <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                            </div>
                        </div>
                        
                        <h2 class="heading-font fw-bold text-dark mb-3">Permohonan Berhasil Dikirim!</h2>
                        <p class="text-muted mb-4">Terima kasih, permohonan informasi Anda telah kami terima dan akan segera diproses oleh tim PPID selambat-lambatnya dalam 10 hari kerja.</p>
                        
                        <div class="bg-light border rounded p-4 mb-4">
                            <span class="d-block text-muted small text-uppercase fw-semibold mb-1" style="letter-spacing: 1px;">Nomor Tiket Anda</span>
                            <span class="display-6 fw-bold text-primary heading-font user-select-all"><?= esc($ticketNumber) ?></span>
                        </div>
                        
                        <div class="alert alert-warning border-0 text-start small mb-5">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Penting:</strong> Simpan nomor tiket di atas dengan baik. Anda dapat menggunakannya untuk melacak status permohonan Anda.
                        </div>
                        
                        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                            <a href="<?= base_url('/permohonan/lacak') ?>" class="btn btn-primary-custom px-4 py-2 fw-semibold">
                                <i class="bi bi-search me-2"></i> Lacak Status
                            </a>
                            <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary px-4 py-2">
                                Kembali ke Beranda
                            </a>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
