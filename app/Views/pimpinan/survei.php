<?= $this->extend('layouts/pimpinan') ?>

<?= $this->section('content') ?>
<div class="container-fluid p-0">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 pt-4 pb-2">
            <h5 class="card-title fw-bold mb-0">Hasil Survei Kepuasan Masyarakat</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" width="5%">No</th>
                            <th width="15%">Tanggal</th>
                            <th width="15%">No. Tiket</th>
                            <th width="20%">Pemohon</th>
                            <th width="15%">Rating</th>
                            <th width="30%">Feedback</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($surveys)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-star fs-1 d-block mb-2"></i>
                                    Belum ada data survei.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach ($surveys as $survey): ?>
                                <tr>
                                    <td class="ps-4 text-muted"><?= $no++ ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($survey['created_at'])) ?></td>
                                    <td>
                                        <?php if(!empty($survey['ticket_number'])): ?>
                                            <span class="badge bg-light text-dark border"><?= esc($survey['ticket_number']) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($survey['applicant_name'] ?? 'Anonim') ?></td>
                                    <td>
                                        <div class="text-warning">
                                            <?php 
                                            $r = (int)$survey['rating'];
                                            for($i=1; $i<=5; $i++) {
                                                echo ($r >= $i) ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star"></i>';
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?= !empty($survey['feedback']) ? nl2br(esc($survey['feedback'])) : '<span class="text-muted">Tidak ada ulasan</span>' ?>
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
<?= $this->endSection() ?>
