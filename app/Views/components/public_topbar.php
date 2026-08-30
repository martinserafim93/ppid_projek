<div class="topbar d-none d-lg-block" style="position: relative; z-index: 1030;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8 d-flex align-items-center">
                <img src="<?= base_url(getSetting('site_logo') ?: 'assets/img/kemenag-new-2025.png') ?>" alt="Logo Kemenag" class="me-2" style="height: 35px;">
                <div>
                    <strong class="d-block text-dark heading-font" style="font-size: 15px;"><?= esc(getSetting('site_name') ?? 'PPID Kantor Wilayah Kementerian Agama Provinsi Kalimantan Utara') ?></strong>
                    <span class="text-muted" style="font-size: 13px;">Melayani dengan Ikhlas, Transparan, dan Akuntabel</span>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <?php if(session()->get('logged_in')): ?>
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-sm btn-outline-primary-custom rounded-pill dropdown-toggle" type="button" id="dropdownAkun" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i> Akun Saya
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="dropdownAkun">
                            <li><h6 class="dropdown-header text-truncate" style="max-width: 200px;"><?= esc(session()->get('user_name')) ?></h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <?php if(session()->get('user_role') === 'admin'): ?>
                                <li><a class="dropdown-item" href="<?= base_url('admin/dashboard') ?>"><i class="bi bi-speedometer2 me-2"></i>Dashboard Admin</a></li>
                            <?php elseif(session()->get('user_role') === 'pimpinan'): ?>
                                <li><a class="dropdown-item" href="<?= base_url('pimpinan/dashboard') ?>"><i class="bi bi-speedometer2 me-2"></i>Dashboard Pimpinan</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="<?= base_url('permohonan/riwayat') ?>"><i class="bi bi-clock-history me-2"></i>Riwayat Permohonan</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item text-danger" href="<?= base_url('user/logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Keluar</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="<?= base_url('user/login') ?>" class="btn btn-sm btn-outline-primary-custom rounded-pill">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk / Daftar
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
