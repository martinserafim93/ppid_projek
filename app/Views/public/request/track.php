<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<section class="py-5 bg-light min-vh-100">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="text-center mb-5" data-aos="fade-down">
                    <h6 class="text-primary fw-bold text-uppercase" style="letter-spacing: 2px;">Layanan Publik</h6>
                    <h2 class="heading-font fw-bold text-dark">Lacak Status Permohonan</h2>
                    <p class="text-muted">Masukkan nomor tiket permohonan informasi Anda untuk mengetahui status terkininya.</p>
                </div>

                <div class="card-glass border-0 shadow-sm mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="p-4 p-md-5">
                        
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show border-0" role="alert">
                                <i class="bi bi-exclamation-circle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('/permohonan/lacak') ?>" method="POST" class="d-flex flex-column flex-md-row gap-3">
                            <?= csrf_field() ?>
                            <div class="flex-grow-1 form-floating">
                                <input type="text" class="form-control" id="ticket_number" name="ticket_number" placeholder="PPID-KALTARA-202X-XXXXX" required value="<?= old('ticket_number') ?? (isset($ticketData) ? esc($ticketData['ticket_number']) : '') ?>">
                                <label for="ticket_number">Nomor Tiket (Contoh: PPID-KALTARA-2025-00001)</label>
                            </div>
                            <button type="submit" class="btn btn-primary-custom px-4 py-3 fw-semibold shadow-sm d-flex align-items-center justify-content-center">
                                <i class="bi bi-search me-2"></i> Lacak Tiket
                            </button>
                        </form>
                    </div>
                </div>
                
                <?php if(isset($ticketData) && $ticketData): ?>
                    <div class="card-glass border-0 shadow-sm" data-aos="fade-up" data-aos-delay="200">
                        <div class="p-4 p-md-5">
                            <h5 class="heading-font fw-bold border-bottom pb-3 mb-4">Hasil Pelacakan Tiket</h5>
                            
                            <div class="row mb-4">
                                <div class="col-sm-4 text-muted small text-uppercase fw-semibold mb-1 mb-sm-0">Nomor Tiket</div>
                                <div class="col-sm-8 fw-bold text-primary"><?= esc($ticketData['ticket_number']) ?></div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-4 text-muted small text-uppercase fw-semibold mb-1 mb-sm-0">Pemohon</div>
                                <div class="col-sm-8 fw-medium"><?= esc($ticketData['user_name']) ?></div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-4 text-muted small text-uppercase fw-semibold mb-1 mb-sm-0">Subjek</div>
                                <div class="col-sm-8"><?= esc($ticketData['subject']) ?></div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-4 text-muted small text-uppercase fw-semibold mb-1 mb-sm-0">Tanggal Pengajuan</div>
                                <div class="col-sm-8"><?= date('d F Y H:i', strtotime($ticketData['created_at'])) ?> WIB</div>
                            </div>
                            
                            <?php 
                                $status = $ticketData['status']; 
                                $statusColor = 'secondary';
                                $statusIcon = 'bi-clock';
                                $statusText = 'Menunggu Diproses';
                                
                                if($status == 'process') {
                                    $statusColor = 'warning';
                                    $statusIcon = 'bi-arrow-repeat';
                                    $statusText = 'Sedang Diproses';
                                } else if($status == 'approved') {
                                    $statusColor = 'success';
                                    $statusIcon = 'bi-check-circle-fill';
                                    $statusText = 'Disetujui / Selesai';
                                } else if($status == 'rejected') {
                                    $statusColor = 'danger';
                                    $statusIcon = 'bi-x-circle-fill';
                                    $statusText = 'Ditolak';
                                }
                            ?>
                            
                            <div class="row mb-4">
                                <div class="col-sm-4 text-muted small text-uppercase fw-semibold mb-1 mb-sm-0">Status Saat Ini</div>
                                <div class="col-sm-8">
                                    <span class="badge bg-<?= $statusColor ?> bg-opacity-10 text-<?= $statusColor ?> border border-<?= $statusColor ?> px-3 py-2 rounded-pill">
                                        <i class="bi <?= $statusIcon ?> me-1"></i> <?= $statusText ?>
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Timeline UI (Sederhana) -->
                            <div class="mt-5 position-relative">
                                <div class="position-absolute top-0 bottom-0 ms-3 border-start border-2 border-primary opacity-25" style="left: 0.2rem;"></div>
                                
                                <div class="d-flex mb-4 position-relative">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 30px; height: 30px; z-index: 2;">
                                        <i class="bi bi-check" style="line-height: 1;"></i>
                                    </div>
                                    <div class="ms-4 pb-3 border-bottom w-100">
                                        <h6 class="fw-bold mb-1">Tiket Diterima</h6>
                                        <p class="text-muted small mb-0"><?= date('d M Y H:i', strtotime($ticketData['created_at'])) ?></p>
                                    </div>
                                </div>
                                
                                <?php if(in_array($status, ['process', 'approved', 'rejected'])): ?>
                                <div class="d-flex mb-4 position-relative">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 30px; height: 30px; z-index: 2;">
                                        <i class="bi bi-check" style="line-height: 1;"></i>
                                    </div>
                                    <div class="ms-4 pb-3 border-bottom w-100">
                                        <h6 class="fw-bold mb-1">Sedang Diproses oleh Admin</h6>
                                        <p class="text-muted small mb-0">Tiket Anda sedang ditinjau dan dokumen sedang disiapkan.</p>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                                <?php if($status == 'approved'): ?>
                                <div class="d-flex position-relative">
                                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 30px; height: 30px; z-index: 2;">
                                        <i class="bi bi-check-all" style="line-height: 1;"></i>
                                    </div>
                                    <div class="ms-4 w-100">
                                        <h6 class="fw-bold text-success mb-1">Selesai (Disetujui)</h6>
                                        <p class="text-muted small mb-0">Informasi telah diberikan. Silakan login ke akun Anda untuk mengunduh balasan/lampiran.</p>
                                    </div>
                                </div>
                                <?php elseif($status == 'rejected'): ?>
                                <div class="d-flex position-relative">
                                    <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 30px; height: 30px; z-index: 2;">
                                        <i class="bi bi-x" style="line-height: 1;"></i>
                                    </div>
                                    <div class="ms-4 w-100">
                                        <h6 class="fw-bold text-danger mb-1">Permohonan Ditolak</h6>
                                        <p class="text-muted small mb-0">Silakan login ke akun Anda untuk melihat alasan penolakan atau mengajukan keberatan.</p>
                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="d-flex position-relative">
                                    <div class="bg-light border text-muted rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 30px; height: 30px; z-index: 2;">
                                        <i class="bi bi-three-dots" style="line-height: 1;"></i>
                                    </div>
                                    <div class="ms-4 w-100">
                                        <h6 class="text-muted mb-1">Keputusan Akhir</h6>
                                        <p class="text-muted small mb-0">Menunggu penyelesaian permohonan.</p>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if(!session()->get('logged_in')): ?>
                            <div class="alert alert-primary border-0 mt-4 d-flex align-items-center">
                                <i class="bi bi-info-circle-fill me-3 fs-4"></i>
                                <div class="small">
                                    Ingin melihat detail balasan atau mengunduh lampiran resmi? <a href="<?= base_url('auth/login') ?>" class="fw-bold text-primary">Login ke Akun Anda</a>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
