<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kelola Infografis</h1>
    <a href="<?= base_url('admin/infographics/create') ?>" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Infografis
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

<?php if (empty($infographics)) : ?>
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body text-center py-5">
            <i class="bi bi-images fs-1 d-block mb-3 text-muted"></i>
            <h5 class="text-muted">Belum ada data infografis</h5>
            <p class="text-muted small mb-0">Klik tombol "Tambah Infografis" di atas untuk menambahkan data baru.</p>
        </div>
    </div>
<?php else : ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4 mb-4">
        <?php foreach ($infographics as $item) : ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0 position-relative overflow-hidden infographic-card">
                    
                    <?php if (!$item['is_active']) : ?>
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 z-1 d-flex justify-content-center align-items-center flex-column" style="pointer-events: none;">
                            <span class="badge bg-danger fs-6 mb-2">Nonaktif</span>
                        </div>
                    <?php endif; ?>

                    <div class="ratio ratio-4x3 bg-light border-bottom">
                        <?php if (!empty($item['image_path'])) : ?>
                            <img src="<?= base_url($item['image_path']) ?>" class="object-fit-cover" alt="<?= esc($item['title']) ?>">
                        <?php else : ?>
                            <div class="d-flex align-items-center justify-content-center h-100 bg-secondary bg-opacity-10">
                                <i class="bi bi-image text-secondary fs-1"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-body p-4 pt-3 z-2 bg-white d-flex flex-column">
                        <h6 class="card-title fw-bold text-dark text-truncate mb-1" title="<?= esc($item['title']) ?>">
                            <?= esc($item['title']) ?>
                        </h6>
                        <div class="small text-muted mb-4 text-truncate">
                            <?= !empty($item['description']) ? esc($item['description']) : '<span class="text-light-subtle">-</span>' ?>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <div class="text-secondary small fw-medium" title="Urutan Tampil">
                                <i class="bi bi-list-ol me-1"></i> <?= $item['sort_order'] ?>
                            </div>
                            
                            <div class="d-flex gap-1 z-3" style="pointer-events: auto;">
                                <a href="<?= base_url('admin/infographics/edit/' . $item['id']) ?>" class="btn btn-sm btn-light text-primary border" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-light text-danger border btn-delete" data-id="<?= $item['id'] ?>" data-title="<?= esc($item['title']) ?>" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <?php if ($pager->getPageCount() > 1) : ?>
        <div class="d-flex justify-content-center mb-4">
            <?= $pager->links('default', 'bootstrap_pagination') ?>
        </div>
    <?php endif; ?>
<?php endif; ?>

<style>
.infographic-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}
.infographic-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    z-index: 5;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const title = this.getAttribute('data-title');
            
            Swal.fire({
                title: 'Konfirmasi Hapus',
                html: `Apakah Anda yakin ingin menghapus infografis <strong>${title}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url('admin/infographics/delete/') ?>' + id;
                }
            });
        });
    });
});
</script>

<?= $this->endSection() ?>
