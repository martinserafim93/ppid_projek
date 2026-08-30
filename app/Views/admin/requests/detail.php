<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h3 mb-0 text-gray-800">Detail Permohonan</h2>
    <a href="<?= base_url('admin/requests') ?>" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i> <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle me-1"></i> <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row">
    <!-- Kolom Kiri: Informasi Permohonan -->
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Tiket: <?= esc($request['ticket_number']) ?></h6>
                <?php 
                    $status = $request['status'];
                    $badgeClass = 'warning';
                    $statusText = 'Pending';
                    
                    if($status == 'process') { $badgeClass = 'info'; $statusText = 'Diproses'; }
                    else if($status == 'approved') { $badgeClass = 'success'; $statusText = 'Disetujui'; }
                    else if($status == 'rejected') { $badgeClass = 'danger'; $statusText = 'Ditolak'; }
                    else if($status == 'objection') { $badgeClass = 'dark'; $statusText = 'Keberatan'; }
                ?>
                <span class="badge bg-<?= $badgeClass ?> bg-opacity-10 text-<?= $badgeClass ?> border border-<?= $badgeClass ?> px-3 py-2 rounded-pill fs-6">
                    <?= $statusText ?>
                </span>
            </div>
            <div class="card-body p-4">
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted fw-semibold">Pemohon</div>
                    <div class="col-sm-8 fw-bold"><?= esc($request['user_name']) ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted fw-semibold">Email & No. HP</div>
                    <div class="col-sm-8"><?= esc($request['email']) ?> / <?= esc($request['phone']) ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted fw-semibold">NIK</div>
                    <div class="col-sm-8"><?= esc($request['nik']) ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted fw-semibold">Subjek</div>
                    <div class="col-sm-8"><?= esc($request['subject']) ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted fw-semibold">Tujuan Penggunaan</div>
                    <div class="col-sm-8"><?= esc($request['purpose']) ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted fw-semibold">Rincian Informasi</div>
                    <div class="col-sm-8 border rounded p-3 bg-light">
                        <?= nl2br(esc($request['description'])) ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted fw-semibold">Tanggal Diajukan</div>
                    <div class="col-sm-8"><?= formatWita($request['created_at']) ?> WITA</div>
                </div>

                <?php if(!empty($files)): ?>
                <hr>
                <h6 class="fw-bold mb-3">Lampiran Dokumen Pemohon</h6>
                <div class="d-flex flex-wrap gap-2">
                    <?php foreach($files as $file): ?>
                        <a href="<?= base_url($file['file_path']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-file-earmark-arrow-down"></i> <?= esc($file['file_name']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pesan Balasan Admin</h6>
            </div>
            <div class="card-body p-4">
                <?php if (!empty($request['response'])): ?>
                    <div class="text-muted small mb-1"><?= esc($request['user_name']) ?> / Admin PPID</div>
                    <div class="border rounded p-3 bg-light mb-3">
                        <?= nl2br(esc($request['response'])) ?>
                    </div>
                    <?php if (!empty($request['responded_at'])): ?>
                        <div class="small text-muted">
                            <i class="bi bi-clock me-1"></i>Dibalas: <?= formatWita($request['responded_at']) ?> WITA
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($request['response_file'])): ?>
                        <a href="<?= base_url($request['response_file']) ?>" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="bi bi-file-earmark-arrow-down me-1"></i> Dokumen Balasan
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-muted">Belum ada pesan balasan untuk permohonan ini.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Aksi Proses -->
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary">Proses Permohonan</h6>
            </div>
            <div class="card-body p-4">
                <form id="updateRequestForm" action="<?= base_url('admin/requests/update/' . $request['slug']) ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ubah Status</label>
                        <select name="status" id="statusSelect" class="form-select" required onchange="toggleFields()">
                            <option value="pending" <?= $status == 'pending' ? 'selected' : '' ?>>Pending (Menunggu)</option>
                            <option value="process" <?= $status == 'process' ? 'selected' : '' ?>>Process (Sedang Diproses)</option>
                            <option value="approved" <?= $status == 'approved' ? 'selected' : '' ?>>Approved (Disetujui)</option>
                            <option value="rejected" <?= $status == 'rejected' ? 'selected' : '' ?>>Rejected (Ditolak)</option>
                            <?php if($status == 'objection'): ?>
                            <option value="objection" selected>Objection (Keberatan)</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3" id="responseWrap">
                        <label class="form-label fw-bold" id="responseLabel">Balasan / Alasan Penolakan</label>
                        <textarea name="response" class="form-control" rows="5" placeholder="Tuliskan keterangan..." required><?= esc($request['response']) ?></textarea>
                        <small class="text-muted mt-1 d-block" id="responseHelp">Wajib diisi jika menolak permohonan. (Untuk Keberatan, riwayat keberatan user juga tercatat di sini)</small>
                    </div>

                    <div class="mb-4" id="fileWrap">
                        <label class="form-label fw-bold">Unggah Dokumen Balasan (Opsional)</label>
                        <?php if(!empty($request['response_file'])): ?>
                            <div class="mb-2">
                                <a href="<?= base_url($request['response_file']) ?>" target="_blank" class="badge bg-success text-decoration-none">
                                    <i class="bi bi-download"></i> Dokumen Saat Ini
                                </a>
                            </div>
                        <?php endif; ?>
                        <input type="file" name="response_file" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip,.rar">
                        <small class="text-muted">Hanya muncul jika status Disetujui (Approved).</small>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 hover-lift">
                        <i class="bi bi-save me-1"></i> Simpan Pembaruan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function toggleFields() {
        const status = document.getElementById('statusSelect').value;
        const fileWrap = document.getElementById('fileWrap');
        const responseLabel = document.getElementById('responseLabel');
        const responseHelp = document.getElementById('responseHelp');

        if (status === 'approved') {
            fileWrap.style.display = 'block';
            responseLabel.innerHTML = 'Pesan Balasan untuk Pemohon <span class="text-danger">*</span>';
            responseHelp.innerText = 'Pesan ini akan terlihat oleh pemohon. Wajib diisi.';
        } else if (status === 'rejected') {
            fileWrap.style.display = 'none';
            responseLabel.innerHTML = 'Alasan Penolakan <span class="text-danger">*</span>';
            responseHelp.innerText = 'Wajib diisi mengapa permohonan ini ditolak.';
        } else {
            fileWrap.style.display = 'none';
            responseLabel.innerHTML = 'Pesan Balasan untuk Pemohon <span class="text-danger">*</span>';
            responseHelp.innerText = 'Pesan ini akan terlihat oleh pemohon. Wajib diisi.';
        }
    }

    // Run on load
    document.addEventListener('DOMContentLoaded', function() {
        toggleFields();
        
        document.getElementById('updateRequestForm').addEventListener('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Simpan Pembaruan Status?',
                text: "Pastikan pesan balasan sudah sesuai.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1B5E20',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Simpan'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
