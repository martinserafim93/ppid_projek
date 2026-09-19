<?= $this->extend('layouts/pimpinan') ?>

<?= $this->section('content') ?>
<style>
    .table-hover tbody tr { transition: background-color 0.2s, transform 0.2s; }
    .table-hover tbody tr:hover { background-color: #fcfcfc; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.02); }
    
    .star-rating-display { color: #e4e5e9; font-size: 1.1rem; letter-spacing: 2px; }
    .star-rating-display .bi-star-fill { color: #ffc107; text-shadow: 0 0 5px rgba(255,193,7,0.3); }
    
    .feedback-text {
        font-size: 0.95rem;
        line-height: 1.5;
        color: #4a5568;
        font-style: italic;
    }
    
    .btn-action {
        width: 32px; height: 32px;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 8px; transition: all 0.2s;
        border: none; background: transparent;
    }
    .btn-action.edit:hover { background: rgba(13, 202, 240, 0.1); color: #087f98; }
    .btn-action.delete:hover { background: rgba(220, 53, 69, 0.1); color: #dc3545; }
    
    /* Interactive Star Rating for Forms */
    .rating-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 0.5rem;
    }
    .rating-input input { display: none; }
    .rating-input label {
        font-size: 2rem; color: #e4e5e9; cursor: pointer; transition: color 0.2s;
    }
    .rating-input label:hover,
    .rating-input label:hover ~ label,
    .rating-input input:checked ~ label {
        color: #ffc107;
        text-shadow: 0 0 10px rgba(255,193,7,0.4);
    }
</style>

<div class="container-fluid p-0">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1" style="color: #1A237E;">Hasil Survei Kepuasan Masyarakat</h4>
            <p class="text-muted mb-0">Kelola ulasan dan tingkat kepuasan dari pemohon informasi publik</p>
        </div>
        <div>
            <button type="button" class="btn text-white rounded-pill px-4 shadow-sm" style="background: linear-gradient(135deg, #1A237E, #283593); border: none;" data-bs-toggle="modal" data-bs-target="#modalTambahSurvei">
                <i class="bi bi-plus-circle me-2"></i> Tambah Respon Manual
            </button>
        </div>
    </div>

    <!-- Error/Success Alerts -->
    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="alert alert-danger rounded-3 shadow-sm border-0 mb-4">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <!-- Table Card -->
    <div class="card bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 border-0 rounded-start" width="5%">No</th>
                            <th class="border-0" width="12%">Tanggal</th>
                            <th class="border-0" width="12%">No. Tiket</th>
                            <th class="border-0" width="18%">Pemohon</th>
                            <th class="border-0" width="13%">Tingkat Kepuasan</th>
                            <th class="border-0" width="30%">Ulasan / Masukan</th>
                            <th class="border-0 rounded-end text-center" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php if (empty($surveys)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-3 text-warning" style="width: 80px; height: 80px;">
                                        <i class="bi bi-star-fill fs-1"></i>
                                    </div>
                                    <h5 class="fw-medium text-dark">Belum Ada Data Survei</h5>
                                    <p class="text-muted">Tambahkan respon manual atau tunggu pemohon mengisi survei.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach ($surveys as $survey): ?>
                                <tr>
                                    <td class="ps-4 text-muted fw-medium py-4"><?= $no++ ?></td>
                                    <td>
                                        <div class="text-dark fw-medium"><?= date('d M Y', strtotime($survey['created_at'])) ?></div>
                                        <div class="small text-muted"><?= date('H:i', strtotime($survey['created_at'])) ?></div>
                                    </td>
                                    <td>
                                        <?php if(!empty($survey['ticket_number'])): ?>
                                            <span class="fw-bold" style="color: #1A237E;"><?= esc($survey['ticket_number']) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted fst-italic">Tanpa Tiket</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold me-2 shadow-sm" style="width: 36px; height: 36px; font-size: 0.9rem; background: linear-gradient(135deg, #1A237E, #283593);">
                                                <?= substr(esc($survey['applicant_name'] ?? 'A'), 0, 1) ?>
                                            </div>
                                            <span class="fw-medium text-dark"><?= esc($survey['applicant_name'] ?? 'Anonim') ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="star-rating-display">
                                            <?php 
                                            $r = (int)$survey['rating'];
                                            for($i=1; $i<=5; $i++) {
                                                echo ($r >= $i) ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star"></i>';
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if(!empty($survey['feedback'])): ?>
                                            <div class="feedback-text bg-light p-3 rounded-3 border">
                                                "<?= nl2br(esc($survey['feedback'])) ?>"
                                            </div>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted fw-normal border">Tidak ada ulasan tertulis</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button type="button" class="btn-action edit text-muted" 
                                                onclick="openEditModal(<?= $survey['id'] ?>, <?= $survey['rating'] ?>, '<?= esc(htmlspecialchars($survey['feedback'], ENT_QUOTES)) ?>', '<?= esc($survey['ticket_number']) ?>')" 
                                                title="Edit Survei">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button type="button" class="btn-action delete text-muted" 
                                                onclick="confirmDelete(<?= $survey['id'] ?>)" 
                                                title="Hapus Survei">
                                                <i class="bi bi-trash"></i>
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
    </div>
</div>

<!-- Modal Tambah Survei -->
<div class="modal fade" id="modalTambahSurvei" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered border-0">
        <div class="modal-content border-0 rounded-4 shadow-lg" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" style="color: #1A237E;">Tambah Respon Manual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('pimpinan/survei/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body px-4 py-4">
                    <div class="mb-4">
                        <label class="form-label text-muted fw-medium small mb-2">Pilih Permohonan (No. Tiket)</label>
                        <select name="request_id" class="form-select bg-light border-0 py-2" required>
                            <option value="">-- Pilih Permohonan --</option>
                            <?php if(!empty($availableRequests)): ?>
                                <?php foreach($availableRequests as $req): ?>
                                    <option value="<?= $req['id'] ?>"><?= esc($req['ticket_number']) ?> - <?= esc($req['subject']) ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>Tidak ada permohonan yang bisa disurvei</option>
                            <?php endif; ?>
                        </select>
                        <div class="form-text small">Hanya menampilkan permohonan selesai yang belum disurvei.</div>
                    </div>
                    
                    <div class="mb-4 text-center">
                        <label class="form-label text-muted fw-medium small mb-2 d-block">Tingkat Kepuasan</label>
                        <div class="rating-input">
                            <input type="radio" id="star5" name="rating" value="5" required />
                            <label for="star5" title="Sangat Puas"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" id="star4" name="rating" value="4" />
                            <label for="star4" title="Puas"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" id="star3" name="rating" value="3" />
                            <label for="star3" title="Cukup"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" id="star2" name="rating" value="2" />
                            <label for="star2" title="Kurang Puas"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" id="star1" name="rating" value="1" />
                            <label for="star1" title="Sangat Kurang"><i class="bi bi-star-fill"></i></label>
                        </div>
                    </div>
                    
                    <div class="mb-2">
                        <label class="form-label text-muted fw-medium small mb-2">Ulasan / Masukan (Opsional)</label>
                        <textarea name="feedback" class="form-control bg-light border-0" rows="4" placeholder="Ketik ulasan pemohon di sini..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white rounded-pill px-4 shadow-sm" style="background: linear-gradient(135deg, #1A237E, #283593); border: none;">Simpan Respon</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Survei -->
<div class="modal fade" id="modalEditSurvei" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered border-0">
        <div class="modal-content border-0 rounded-4 shadow-lg" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" style="color: #1A237E;">Edit Respon Survei</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditSurvei" action="" method="post">
                <?= csrf_field() ?>
                <div class="modal-body px-4 py-4">
                    <div class="mb-4">
                        <label class="form-label text-muted fw-medium small mb-2">Nomor Tiket</label>
                        <input type="text" id="editTicketNumber" class="form-control bg-light border-0 py-2 text-muted" readonly disabled>
                    </div>
                    
                    <div class="mb-4 text-center">
                        <label class="form-label text-muted fw-medium small mb-2 d-block">Tingkat Kepuasan</label>
                        <div class="rating-input">
                            <input type="radio" id="editStar5" name="rating" value="5" required />
                            <label for="editStar5" title="Sangat Puas"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" id="editStar4" name="rating" value="4" />
                            <label for="editStar4" title="Puas"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" id="editStar3" name="rating" value="3" />
                            <label for="editStar3" title="Cukup"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" id="editStar2" name="rating" value="2" />
                            <label for="editStar2" title="Kurang Puas"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" id="editStar1" name="rating" value="1" />
                            <label for="editStar1" title="Sangat Kurang"><i class="bi bi-star-fill"></i></label>
                        </div>
                    </div>
                    
                    <div class="mb-2">
                        <label class="form-label text-muted fw-medium small mb-2">Ulasan / Masukan</label>
                        <textarea id="editFeedback" name="feedback" class="form-control bg-light border-0" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white rounded-pill px-4 shadow-sm" style="background: linear-gradient(135deg, #1A237E, #283593); border: none;">Update Respon</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // SweetAlert for Flash Messages
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= esc(session()->getFlashdata('success')) ?>',
            timer: 3000,
            showConfirmButton: false,
            customClass: { popup: 'rounded-4 shadow-lg' }
        });
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '<?= esc(session()->getFlashdata('error')) ?>',
            customClass: { popup: 'rounded-4 shadow-lg' }
        });
    <?php endif; ?>

    // Handle Edit Modal Population
    function openEditModal(id, rating, feedback, ticket) {
        // Set form action
        document.getElementById('formEditSurvei').action = '<?= base_url('pimpinan/survei/update') ?>/' + id;
        
        // Set info
        document.getElementById('editTicketNumber').value = ticket;
        document.getElementById('editFeedback').value = feedback;
        
        // Set rating
        document.getElementById('editStar' + rating).checked = true;
        
        // Show modal
        var editModal = new bootstrap.Modal(document.getElementById('modalEditSurvei'));
        editModal.show();
    }

    // Handle Delete Confirmation
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Data Survei?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-4 shadow-lg',
                confirmButton: 'rounded-pill px-4',
                cancelButton: 'rounded-pill px-4'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?= base_url('pimpinan/survei/delete') ?>/' + id;
            }
        });
    }
</script>
<?= $this->endSection() ?>
