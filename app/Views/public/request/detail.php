<?= $this->extend('layouts/public') ?>

<?= $this->section('content') ?>
<section class="py-5 bg-light min-vh-100">
    <div class="container py-4">
        <div class="row">
            <!-- Sidebar for User Menu -->
            <div class="col-lg-3 mb-4 mb-lg-0">
                <div class="card-glass border-0 shadow-sm rounded-4 overflow-hidden position-sticky" style="top: 100px;">
                    <div class="bg-primary text-white p-4 text-center">
                        <div class="bg-white bg-opacity-25 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-person fs-1"></i>
                        </div>
                        <h5 class="fw-bold mb-0 text-truncate"><?= esc(session()->get('user_name')) ?></h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="<?= base_url('permohonan/buat') ?>" class="list-group-item list-group-item-action p-3">
                            <i class="bi bi-plus-circle me-2"></i> Buat Permohonan Baru
                        </a>
                        <a href="<?= base_url('permohonan/riwayat') ?>" class="list-group-item list-group-item-action p-3 active bg-primary bg-opacity-10 text-primary border-start border-4 border-primary">
                            <i class="bi bi-clock-history me-2"></i> Riwayat Permohonan
                        </a>
                        <a href="<?= base_url('user/logout') ?>" class="list-group-item list-group-item-action text-danger p-3" onclick="event.preventDefault(); Swal.fire({title: 'Konfirmasi Keluar', text: 'Apakah Anda yakin ingin keluar dari portal?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc3545', cancelButtonColor: '#6c757d', confirmButtonText: 'Ya, Keluar'}).then((result) => { if (result.isConfirmed) { window.location.href = this.href; } });">
                            <i class="bi bi-box-arrow-right me-2"></i> Keluar
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <a href="<?= base_url('permohonan/riwayat') ?>" class="text-muted text-decoration-none small mb-2 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat</a>
                        <h3 class="heading-font fw-bold text-dark mb-0">Rincian Permohonan</h3>
                    </div>
                </div>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php 
                    $status = $request['status']; 
                    $statusColor = 'secondary';
                    $statusText = 'Menunggu Diproses';
                    $statusIcon = 'bi-clock';
                    
                    if($status == 'process') {
                        $statusColor = 'warning';
                        $statusText = 'Sedang Diproses';
                        $statusIcon = 'bi-arrow-repeat';
                    } else if($status == 'approved') {
                        $statusColor = 'success';
                        $statusText = 'Disetujui / Selesai';
                        $statusIcon = 'bi-check-circle-fill';
                    } else if($status == 'rejected') {
                        $statusColor = 'danger';
                        $statusText = 'Ditolak';
                        $statusIcon = 'bi-x-circle-fill';
                    } else if($status == 'objection') {
                        $statusColor = 'info';
                        $statusText = 'Pengajuan Keberatan';
                        $statusIcon = 'bi-shield-exclamation';
                    }
                ?>

                <!-- Informasi Utama -->
                <div class="card-glass border-0 shadow-sm rounded-4 mb-4" data-aos="fade-up">
                    <div class="p-4 p-md-5">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 pb-3 border-bottom">
                            <div>
                                <div class="text-muted small text-uppercase fw-semibold mb-1">Nomor Tiket</div>
                                <h4 class="fw-bold text-primary mb-0 user-select-all"><?= esc($request['ticket_number']) ?></h4>
                            </div>
                            <div class="text-md-end">
                                <span class="badge bg-<?= $statusColor ?> bg-opacity-10 text-<?= $statusColor ?> px-3 py-2 rounded-pill fs-6 border border-<?= $statusColor ?>">
                                    <i class="bi <?= $statusIcon ?> me-2"></i> <?= $statusText ?>
                                </span>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="text-muted small text-uppercase fw-semibold mb-1">Subjek Permohonan</div>
                                <p class="fw-medium text-dark mb-0"><?= esc($request['subject']) ?></p>
                            </div>
                            <div class="col-md-6">
                                <div class="text-muted small text-uppercase fw-semibold mb-1">Tanggal Pengajuan</div>
                                <p class="text-dark mb-0"><?= formatWita($request['created_at'], 'd F Y H:i') ?> WITA</p>
                            </div>
                            <div class="col-12">
                                <div class="text-muted small text-uppercase fw-semibold mb-1">Rincian Informasi</div>
                                <div class="bg-white rounded p-3 border mt-1">
                                    <?= nl2br(esc($request['description'])) ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="text-muted small text-uppercase fw-semibold mb-1">Tujuan Penggunaan</div>
                                <p class="text-dark mb-0"><?= esc($request['purpose']) ?></p>
                            </div>
                        </div>

                        <?php if(!empty($files)): ?>
                        <div class="mt-4 pt-4 border-top">
                            <div class="text-muted small text-uppercase fw-semibold mb-3">Lampiran Pemohon</div>
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach($files as $file): ?>
                                    <a href="<?= base_url($file['file_path']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center">
                                        <i class="bi bi-paperclip me-2"></i> <?= esc($file['file_name']) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Balasan Admin (Jika ada) -->
                <?php if($status == 'approved' || $status == 'rejected' || $status == 'objection'): ?>
                <div class="card-glass border-0 shadow-sm rounded-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="p-4 p-md-5 bg-<?= $status == 'rejected' || $status == 'objection' ? 'danger' : 'success' ?> bg-opacity-10" style="border-radius: var(--radius-lg);">
                        <h5 class="heading-font fw-bold mb-4">
                            <i class="bi <?= $status == 'rejected' || $status == 'objection' ? 'bi-exclamation-circle' : 'bi-check-circle' ?> me-2"></i> 
                            Tanggapan PPID
                        </h5>
                        
                        <?php if($status == 'approved'): ?>
                            <?php if (!empty($request['response'])): ?>
                                <div class="bg-white rounded p-3 border mb-3">
                                    <div class="text-muted small text-uppercase fw-semibold mb-1">Pesan Balasan Admin</div>
                                    <?= nl2br(esc($request['response'])) ?>
                                </div>
                            <?php endif; ?>
                            <p class="mb-4">Permohonan Anda telah disetujui. Silakan unduh dokumen/informasi yang Anda minta melalui lampiran resmi di bawah ini.</p>
                            <?php if(!empty($request['response_file'])): ?>
                                <a href="<?= base_url($request['response_file']) ?>" class="btn btn-success px-4 py-2 shadow-sm" target="_blank">
                                    <i class="bi bi-download me-2"></i> Unduh Dokumen Balasan
                                </a>
                            <?php else: ?>
                                <p class="text-success fw-medium"><i class="bi bi-check2-all"></i> Informasi telah diberikan secara langsung atau tidak memiliki lampiran.</p>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if($status == 'rejected' || $status == 'objection'): ?>
                            <div class="alert alert-danger border-0 mb-0">
                                <strong>Alasan Penolakan:</strong><br>
                                <?= nl2br(esc($request['response'] ?? 'Permohonan tidak dapat dipenuhi.')) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Form Keberatan (Hanya jika Ditolak) -->
                <?php if($status == 'rejected'): ?>
                <div class="card-glass border-0 shadow-sm rounded-4 border-start border-4 border-danger" data-aos="fade-up" data-aos-delay="200">
                    <div class="p-4 p-md-5">
                        <h5 class="heading-font fw-bold text-danger mb-3"><i class="bi bi-shield-exclamation me-2"></i> Ajukan Keberatan</h5>
                        <p class="text-muted mb-4">Jika Anda merasa penolakan ini tidak sesuai dengan ketentuan Keterbukaan Informasi Publik, Anda memiliki hak untuk mengajukan keberatan.</p>
                        
                        <form action="<?= base_url('permohonan/keberatan/' . $request['slug']) ?>" method="POST" onsubmit="event.preventDefault(); swalConfirm(this, 'Kirim pengajuan keberatan sekarang?', 'Ya, Kirim', '#dc3545')">
                            <?= csrf_field() ?>
                            <div class="mb-4">
                                <label for="objection_reason" class="form-label fw-semibold">Alasan Keberatan <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="objection_reason" name="objection_reason" rows="4" placeholder="Jelaskan alasan mengapa Anda mengajukan keberatan atas penolakan ini..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger px-4">
                                <i class="bi bi-send-fill me-2"></i> Kirim Pengajuan Keberatan
                            </button>
                        </form>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Form Survei (Hanya jika Disetujui) -->
                <?php if($status == 'approved'): ?>
                <div class="card-glass border-0 shadow-sm rounded-4 border-start border-4 border-success mt-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="p-4 p-md-5">
                        <h5 class="heading-font fw-bold text-success mb-3"><i class="bi bi-star-fill me-2"></i> Survei Kepuasan Masyarakat</h5>
                        <?php if($hasSurveyed): ?>
                            <div class="alert alert-success border-0 mb-0">
                                <i class="bi bi-check-circle-fill me-2"></i> Terima kasih, Anda telah mengisi survei kepuasan untuk layanan ini.
                            </div>
                        <?php else: ?>
                            <p class="text-muted mb-4">Silakan berikan penilaian Anda terhadap layanan informasi yang telah kami berikan.</p>
                            
                            <form action="<?= base_url('permohonan/survei/' . $request['slug']) ?>" method="POST" onsubmit="event.preventDefault(); swalConfirm(this, 'Kirim penilaian sekarang?', 'Ya, Kirim', '#198754')">
                                <?= csrf_field() ?>
                                
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Penilaian Anda <span class="text-danger">*</span></label>
                                    <style>
                                        .star-rating input { display: none; }
                                        .star-rating label { font-size: 2rem; color: #ddd; cursor: pointer; transition: color 0.2s; padding: 0 0.1rem; }
                                        .star-rating label:hover,
                                        .star-rating label:hover ~ label,
                                        .star-rating input:checked ~ label { color: #ffc107; }
                                    </style>
                                    <div class="star-rating d-flex flex-row-reverse justify-content-end align-items-center">
                                        <input type="radio" id="star5" name="rating" value="5" required>
                                        <label for="star5" title="5 Bintang"><i class="bi bi-star-fill"></i></label>
                                        <input type="radio" id="star4" name="rating" value="4">
                                        <label for="star4" title="4 Bintang"><i class="bi bi-star-fill"></i></label>
                                        <input type="radio" id="star3" name="rating" value="3">
                                        <label for="star3" title="3 Bintang"><i class="bi bi-star-fill"></i></label>
                                        <input type="radio" id="star2" name="rating" value="2">
                                        <label for="star2" title="2 Bintang"><i class="bi bi-star-fill"></i></label>
                                        <input type="radio" id="star1" name="rating" value="1">
                                        <label for="star1" title="1 Bintang"><i class="bi bi-star-fill"></i></label>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="feedback" class="form-label fw-semibold">Ulasan / Saran (Opsional)</label>
                                    <textarea class="form-control" id="feedback" name="feedback" rows="3" placeholder="Tuliskan ulasan atau saran Anda untuk perbaikan layanan kami..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="bi bi-send-fill me-2"></i> Kirim Penilaian
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function swalConfirm(form, message, btnText, btnColor = '#1B5E20') {
        Swal.fire({
            title: 'Konfirmasi',
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: btnColor,
            cancelButtonColor: '#6c757d',
            confirmButtonText: btnText
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
<?= $this->endSection() ?>
