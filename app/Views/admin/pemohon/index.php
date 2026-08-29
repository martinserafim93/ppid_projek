<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manajemen Pemohon</h1>
    <a href="<?= base_url('admin/pemohon/create') ?>" class="btn btn-primary">
        <i class="bi bi-person-plus me-1"></i> Tambah Pemohon
    </a>
</div>

<?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between border-bottom">
        <h6 class="m-0 font-weight-bold text-dark">Daftar Masyarakat Umum (Pemohon)</h6>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="30%">Data Pemohon</th>
                        <th width="30%">Kontak</th>
                        <th width="15%" class="text-center">Status</th>
                        <th width="20%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)) : ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-1 d-block mb-2 text-black-50"></i>
                                Belum ada data pemohon yang terdaftar.
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php 
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $no = 1 + (10 * ($page - 1));
                        
                        foreach ($users as $user) : 
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <?php if (!empty($user['avatar'])) : ?>
                                                <img src="<?= base_url($user['avatar']) ?>" class="rounded-circle object-fit-cover" width="40" height="40" alt="<?= esc($user['name']) ?>">
                                            <?php else : ?>
                                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: 600;">
                                                    <?= strtoupper(substr($user['name'], 0, 1)) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">
                                                <?= esc($user['name']) ?>
                                            </div>
                                            <div class="small text-muted mb-1">
                                                <span class="badge bg-light text-dark border border-secondary border-opacity-25" title="NIK">
                                                    <i class="bi bi-person-vcard me-1"></i> <?= esc($user['nik']) ?: 'Tidak Ada NIK' ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-dark small"><i class="bi bi-envelope text-muted me-1"></i> <?= esc($user['email']) ?></div>
                                    <div class="text-dark small mt-1"><i class="bi bi-whatsapp text-success me-1"></i> <?= esc($user['phone']) ?: '-' ?></div>
                                </td>
                                <td class="text-center">
                                    <div class="form-check form-switch d-flex justify-content-center m-0">
                                        <input class="form-check-input toggle-status" type="checkbox" role="switch" 
                                            data-id="<?= $user['id'] ?>" 
                                            <?= $user['is_active'] ? 'checked' : '' ?>>
                                    </div>
                                    <span class="small status-label-<?= $user['id'] ?> <?= $user['is_active'] ? 'text-success' : 'text-danger' ?>">
                                        <?= $user['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('admin/pemohon/edit/' . $user['id']) ?>" class="btn btn-outline-primary" title="Edit Data">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-outline-warning btn-reset" 
                                            data-id="<?= $user['id'] ?>" 
                                            data-name="<?= esc($user['name']) ?>"
                                            title="Reset Password">
                                            <i class="bi bi-key"></i> Reset
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <?php if ($pager->getPageCount() > 1) : ?>
    <div class="card-footer bg-white border-top-0 pt-3 pb-2">
        <?= $pager->links('default', 'bootstrap_pagination') ?>
    </div>
    <?php endif; ?>
</div>

<!-- Modal Detail Reset Password -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="passwordModalLabel"><i class="bi bi-check-circle-fill me-2"></i>Reset Berhasil</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <p class="mb-2 text-muted">Password baru untuk pemohon <strong id="reset-user-name" class="text-dark"></strong>:</p>
                <div class="display-6 fw-bold text-primary mb-3 user-select-all font-monospace" id="new-password-display" style="letter-spacing: 2px;"></div>
                <div class="alert alert-warning mb-0 border-warning border-opacity-25" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 text-warning"></i> 
                    <strong>Penting!</strong> Berikan password ini kepada pemohon tersebut.
                </div>
            </div>
            <div class="modal-footer justify-content-center bg-light">
                <button type="button" class="btn btn-primary px-4" id="btn-copy-password">
                    <i class="bi bi-clipboard me-1"></i> Copy Password
                </button>
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // CSRF Token setup for AJAX
    const csrfName = '<?= csrf_token() ?>';
    const csrfHash = '<?= csrf_hash() ?>';

    // Handle Status Toggle
    const toggleSwitches = document.querySelectorAll('.toggle-status:not(:disabled)');
    
    toggleSwitches.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const id = this.getAttribute('data-id');
            const isChecked = this.checked;
            const label = document.querySelector(`.status-label-${id}`);
            
            // Revert visually immediately, we'll change it via fetch response
            this.checked = !isChecked;
            
            Swal.fire({
                title: isChecked ? 'Aktifkan Akun?' : 'Blokir Akun?',
                text: isChecked ? 'Pemohon akan dapat login kembali.' : 'Pemohon tidak akan dapat mengajukan tiket atau login ke sistem.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: isChecked ? '#198754' : '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`<?= base_url('admin/pemohon/toggle/') ?>${id}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.checked = data.new_status === 1;
                            
                            if (data.new_status === 1) {
                                label.textContent = 'Aktif';
                                label.classList.replace('text-danger', 'text-success');
                            } else {
                                label.textContent = 'Nonaktif';
                                label.classList.replace('text-success', 'text-danger');
                            }
                            
                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message,
                                icon: 'success',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        } else {
                            Swal.fire('Gagal', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
                    });
                }
            });
        });
    });

    // Handle Password Reset
    const resetButtons = document.querySelectorAll('.btn-reset:not(:disabled)');
    const passwordModal = new bootstrap.Modal(document.getElementById('passwordModal'));
    const passwordDisplay = document.getElementById('new-password-display');
    const resetUserName = document.getElementById('reset-user-name');
    const copyBtn = document.getElementById('btn-copy-password');
    
    resetButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            
            Swal.fire({
                title: 'Reset Password Pemohon?',
                html: `Anda akan mereset password untuk pemohon <strong>${name}</strong>.<br><br>Password baru akan dibuatkan secara acak.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Reset Password',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    Swal.fire({
                        title: 'Mereset Password...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    fetch(`<?= base_url('admin/pemohon/reset-password/') ?>${id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: `${csrfName}=${csrfHash}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.close();
                        if (data.success) {
                            resetUserName.textContent = name;
                            passwordDisplay.textContent = data.new_password;
                            passwordModal.show();
                        } else {
                            Swal.fire('Gagal', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.close();
                        Swal.fire('Error', 'Terjadi kesalahan sistem saat mereset password.', 'error');
                    });
                }
            });
        });
    });
    
    // Handle Copy Password
    copyBtn.addEventListener('click', function() {
        const passwordToCopy = passwordDisplay.textContent;
        
        navigator.clipboard.writeText(passwordToCopy).then(function() {
            const originalText = copyBtn.innerHTML;
            copyBtn.innerHTML = '<i class="bi bi-check2-all me-1"></i> Tersalin!';
            copyBtn.classList.replace('btn-primary', 'btn-success');
            
            setTimeout(() => {
                copyBtn.innerHTML = originalText;
                copyBtn.classList.replace('btn-success', 'btn-primary');
            }, 2000);
        });
    });
});
</script>

<?= $this->endSection() ?>
