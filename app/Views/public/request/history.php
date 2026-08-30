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
                        <p class="small text-white-50 mb-0"><?= esc(session()->get('user_email')) ?></p>
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
                    <h3 class="heading-font fw-bold text-dark mb-0">Riwayat Permohonan</h3>
                </div>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 d-flex align-items-center p-3 mb-4" role="alert">
                        <i class="bi bi-exclamation-octagon-fill fs-4 me-3"></i>
                        <div><?= session()->getFlashdata('error') ?></div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (empty($requests)): ?>
                    <div class="card-glass border-0 shadow-sm rounded-4 text-center p-5">
                        <div class="bg-primary-custom-subtle text-primary-custom rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                            <i class="bi bi-inbox-fill" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Belum Ada Permohonan</h4>
                        <p class="text-muted mx-auto mb-4" style="max-width: 500px;">
                            Daftar riwayat permohonan Anda akan tampil di sini. Ajukan permohonan informasi publik pertama Anda untuk melacak status dan mendapatkan dokumen resmi yang Anda butuhkan.
                        </p>
                        <a href="<?= base_url('permohonan/buat') ?>" class="btn btn-primary-custom px-4 py-2 rounded-pill shadow-sm hover-lift fw-medium">
                            <i class="bi bi-plus-lg me-2"></i> Buat Permohonan Sekarang
                        </a>
                    </div>
                <?php else: ?>
                    <div class="row g-4">
                        <?php foreach($requests as $req): ?>
                            <?php 
                                $status = $req['status']; 
                                $statusColor = 'secondary';
                                $statusText = 'Menunggu Diproses';
                                
                                if($status == 'process') {
                                    $statusColor = 'warning';
                                    $statusText = 'Sedang Diproses';
                                } else if($status == 'approved') {
                                    $statusColor = 'success';
                                    $statusText = 'Selesai (Disetujui)';
                                } else if($status == 'rejected') {
                                    $statusColor = 'danger';
                                    $statusText = 'Ditolak';
                                } else if($status == 'objection') {
                                    $statusColor = 'info';
                                    $statusText = 'Pengajuan Keberatan';
                                }
                            ?>
                            <div class="col-12" data-aos="fade-up">
                                <div class="card-glass border-0 shadow-sm rounded-4 transition-hover">
                                    <div class="card-body p-4">
                                        <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                                            <div>
                                                <div class="d-flex align-items-center gap-2 mb-2">
                                                    <span class="badge bg-<?= $statusColor ?> bg-opacity-10 text-<?= $statusColor ?> px-3 py-1 rounded-pill fw-semibold">
                                                        <?= $statusText ?>
                                                    </span>
                                                    <span class="text-muted small"><i class="bi bi-calendar3 me-1"></i> <?= date('d M Y', strtotime($req['created_at'])) ?></span>
                                                </div>
                                                <h5 class="fw-bold text-dark mb-1 user-select-all"><?= esc($req['ticket_number']) ?></h5>
                                                <p class="text-muted mb-0 line-clamp-2"><?= esc($req['subject']) ?></p>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <a href="<?= base_url('permohonan/detail/' . $req['slug']) ?>" class="btn btn-outline-primary-custom w-100 w-md-auto stretched-link">Lihat Detail <i class="bi bi-arrow-right ms-2"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<style>
.transition-hover {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}
.transition-hover:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
}
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;  
    overflow: hidden;
}
</style>
<?= $this->endSection() ?>
