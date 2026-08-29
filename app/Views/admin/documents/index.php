<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kelola Dokumen Publik</h1>
    <div>
        <a href="<?= base_url('admin/categories/documents') ?>" class="btn btn-outline-secondary me-2">
            <i class="bi bi-tags me-1"></i> Kelola Kategori
        </a>
        <a href="<?= base_url('admin/documents/create') ?>" class="btn btn-primary">
            <i class="bi bi-cloud-arrow-up me-1"></i> Upload Dokumen
        </a>
    </div>
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
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-dark">Daftar Dokumen</h6>
        
        <form action="" method="get" class="d-flex" style="width: 300px;">
            <div class="input-group input-group-sm">
                <input type="text" name="q" class="form-control" placeholder="Cari dokumen..." value="<?= esc($keyword ?? '') ?>">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                <?php if (!empty($keyword)) : ?>
                    <a href="<?= base_url('admin/documents') ?>" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
                <?php endif; ?>
            </div>
        </form>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="45%">Detail Dokumen</th>
                        <th width="15%" class="text-center">Ukuran</th>
                        <th width="15%" class="text-center">Status</th>
                        <th width="10%" class="text-center">Unduhan</th>
                        <th width="10%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($documents)) : ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-folder-x fs-1 d-block mb-2 text-black-50"></i>
                                    Belum ada dokumen yang diupload.
                                </div>
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php 
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $no = 1 + (10 * ($page - 1));
                        foreach ($documents as $item) : 
                            
                            // Determine icon based on mime type or extension
                            $icon = 'bi-file-earmark-text';
                            $iconClass = 'text-secondary';
                            
                            if (strpos($item['file_type'], 'pdf') !== false) {
                                $icon = 'bi-file-earmark-pdf-fill';
                                $iconClass = 'text-danger';
                            } elseif (strpos($item['file_type'], 'word') !== false || strpos($item['file_type'], 'document') !== false) {
                                $icon = 'bi-file-earmark-word-fill';
                                $iconClass = 'text-primary';
                            } elseif (strpos($item['file_type'], 'excel') !== false || strpos($item['file_type'], 'sheet') !== false) {
                                $icon = 'bi-file-earmark-excel-fill';
                                $iconClass = 'text-success';
                            } elseif (strpos($item['file_type'], 'zip') !== false || strpos($item['file_type'], 'rar') !== false) {
                                $icon = 'bi-file-earmark-zip-fill';
                                $iconClass = 'text-warning';
                            }
                            
                            // Format size
                            $bytes = $item['file_size'];
                            $size = '0 Byte';
                            if ($bytes >= 1073741824) {
                                $size = number_format($bytes / 1073741824, 2) . ' GB';
                            } elseif ($bytes >= 1048576) {
                                $size = number_format($bytes / 1048576, 2) . ' MB';
                            } elseif ($bytes >= 1024) {
                                $size = number_format($bytes / 1024, 2) . ' KB';
                            } elseif ($bytes > 1) {
                                $size = $bytes . ' Bytes';
                            } elseif ($bytes == 1) {
                                $size = $bytes . ' Byte';
                            }
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="bi <?= $icon ?> <?= $iconClass ?> fs-2"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark mb-1">
                                                <?= esc($item['title']) ?>
                                                <?php if($item['category'] == 'statistik'): ?>
                                                    <span class="badge bg-info ms-1" style="font-size: 0.65rem;">Statistik</span>
                                                <?php endif; ?>
                                            </div>
                                            <?php if (!empty($item['description'])) : ?>
                                                <div class="small text-muted text-truncate" style="max-width: 300px;"><?= esc($item['description']) ?></div>
                                            <?php endif; ?>
                                            <div class="small text-muted mt-1">
                                                <i class="bi bi-clock me-1"></i> <?= date('d M Y, H:i', strtotime($item['created_at'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="fw-medium text-secondary" style="font-size: 0.9rem;"><?= $size ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if ($item['is_active']) : ?>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success">Publik</span>
                                    <?php else : ?>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary">Private</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="text-dark fw-medium" style="font-size: 0.95rem;">
                                        <i class="bi bi-cloud-arrow-down text-muted me-1"></i> <?= number_format($item['download_count']) ?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <button type="button" class="btn btn-sm btn-light text-info border" onclick="copyLink('<?= base_url($item['file_path']) ?>')" title="Salin Link Publik">
                                            <i class="bi bi-link-45deg"></i>
                                        </button>
                                        <a href="<?= base_url('admin/documents/download/' . $item['id']) ?>" class="btn btn-sm btn-light text-success border" title="Download">
                                            <i class="bi bi-download"></i>
                                        </a>
                                        <a href="<?= base_url('admin/documents/edit/' . $item['id']) ?>" class="btn btn-sm btn-light text-primary border" title="Edit Info">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-light text-danger border btn-delete" data-id="<?= $item['id'] ?>" data-title="<?= esc($item['title']) ?>" title="Hapus">
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
    
    <?php if ($pager->getPageCount() > 1) : ?>
    <div class="card-footer bg-white border-top-0 pt-3 pb-2">
        <?= $pager->links('default', 'bootstrap_pagination') ?>
    </div>
    <?php endif; ?>
</div>

<script>
function copyLink(url) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(() => {
            Swal.fire({toast:true, position:'top-end', icon:'success', title:'Link publik disalin!', showConfirmButton:false, timer:2000});
        });
    } else {
        // Fallback for HTTP/Local (non-secure context)
        const textArea = document.createElement("textarea");
        textArea.value = url;
        // Move outside of screen to make it invisible
        textArea.style.position = "absolute";
        textArea.style.left = "-999999px";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            Swal.fire({toast:true, position:'top-end', icon:'success', title:'Link publik disalin!', showConfirmButton:false, timer:2000});
        } catch (err) {
            prompt('Silakan copy link berikut:', url);
        }
        textArea.remove();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const title = this.getAttribute('data-title');
            
            Swal.fire({
                title: 'Konfirmasi Hapus',
                html: `Apakah Anda yakin ingin menghapus dokumen <strong>${title}</strong>?<br><br><span class="text-danger small">File fisik juga akan dihapus permanen.</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url('admin/documents/delete/') ?>' + id;
                }
            });
        });
    });
});
</script>

<?= $this->endSection() ?>
