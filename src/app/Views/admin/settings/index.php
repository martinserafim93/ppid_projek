<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pengaturan Website</h1>
</div>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('message') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<form action="<?= base_url('admin/settings/update') ?>" method="post" enctype="multipart/form-data" id="settingsForm">
    <?= csrf_field() ?>

    <?php foreach ($grouped as $group => $settings) : ?>
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="m-0 font-weight-bold text-dark">
                    <i class="bi <?= $groupIcons[$group] ?? 'bi-sliders' ?> me-2 text-primary"></i>
                    <?= esc($groupLabels[$group] ?? ucwords(str_replace('_', ' ', $group))) ?>
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <?php foreach ($settings as $setting) : ?>
                        <?php
                        $key   = $setting['key'];
                        $value = old($key, $setting['value']);
                        $type  = $setting['type'];
                        $desc  = $setting['description'] ?? ucwords(str_replace('_', ' ', $key));
                        $isRequired = in_array($key, ['site_name']);
                        ?>

                        <?php if ($type === 'image') : ?>
                            <!-- Image Field: Full width -->
                            <div class="col-md-6 mb-4">
                                <label for="<?= $key ?>" class="form-label fw-semibold">
                                    <?= esc($desc) ?>
                                    <?php if ($isRequired) : ?><span class="text-danger">*</span><?php endif; ?>
                                </label>

                                <!-- Current Image Preview -->
                                <div class="p-3 bg-light rounded border mb-3 text-center">
                                    <?php if (!empty($setting['value'])) : ?>
                                        <?php if ($key === 'site_favicon') : ?>
                                            <img src="<?= base_url($setting['value']) ?>" alt="<?= esc($desc) ?>" width="48" height="48" class="img-fluid">
                                        <?php else : ?>
                                            <img src="<?= base_url($setting['value']) ?>" alt="<?= esc($desc) ?>" class="img-fluid" style="max-height: 120px;">
                                        <?php endif; ?>
                                        <div class="mt-2 small text-muted">File saat ini</div>
                                    <?php else : ?>
                                        <div class="text-muted py-3">
                                            <i class="bi bi-image text-secondary fs-1 d-block mb-2"></i>
                                            Belum diupload
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <input class="form-control form-control-sm" id="<?= $key ?>" name="<?= $key ?>" type="file"
                                       accept="image/png, image/jpeg, image/webp<?= $key === 'site_favicon' ? ', image/x-icon' : '' ?>">
                                <?php if ($key === 'site_favicon') : ?>
                                    <div class="form-text small mt-1">Format: PNG ukuran 1:1 (32x32 atau 64x64). Maks: 512KB.</div>
                                <?php else : ?>
                                    <div class="form-text small mt-1">Format: PNG transparan disarankan. Maks: 2MB.</div>
                                <?php endif; ?>
                            </div>

                        <?php elseif ($type === 'textarea') : ?>
                            <!-- Textarea Field: Full width -->
                            <div class="col-12 mb-4">
                                <label for="<?= $key ?>" class="form-label fw-semibold">
                                    <?= esc($desc) ?>
                                    <?php if ($isRequired) : ?><span class="text-danger">*</span><?php endif; ?>
                                </label>
                                <textarea class="form-control" id="<?= $key ?>" name="<?= $key ?>" rows="3"
                                    <?= $isRequired ? 'required' : '' ?>><?= esc($value) ?></textarea>
                            </div>

                        <?php else : ?>
                            <!-- Text Field: Half width -->
                            <div class="col-md-6 mb-4">
                                <label for="<?= $key ?>" class="form-label fw-semibold">
                                    <?= esc($desc) ?>
                                    <?php if ($isRequired) : ?><span class="text-danger">*</span><?php endif; ?>
                                </label>

                                <?php
                                // Determine input icon based on key name
                                $icon = 'bi-pencil';
                                if (strpos($key, 'email') !== false) $icon = 'bi-envelope';
                                elseif (strpos($key, 'phone') !== false) $icon = 'bi-telephone';
                                elseif (strpos($key, 'whatsapp') !== false) $icon = 'bi-whatsapp';
                                elseif (strpos($key, 'footer') !== false) $icon = 'bi-file-text';
                                elseif (strpos($key, 'hours') !== false || strpos($key, 'operating') !== false) $icon = 'bi-clock';
                                elseif (strpos($key, 'name') !== false) $icon = 'bi-building';

                                // Determine input type
                                $inputType = 'text';
                                if (strpos($key, 'email') !== false) $inputType = 'email';
                                elseif (strpos($key, 'link') !== false || strpos($key, 'url') !== false || strpos($key, 'whatsapp') !== false) $inputType = 'url';
                                ?>

                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi <?= $icon ?>"></i></span>
                                    <input type="<?= $inputType ?>" class="form-control" id="<?= $key ?>" name="<?= $key ?>"
                                           value="<?= esc($value) ?>" <?= $isRequired ? 'required' : '' ?>>
                                </div>
                            </div>
                        <?php endif; ?>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Save Button -->
    <div class="mb-4">
        <button type="submit" class="btn btn-primary btn-lg fw-bold px-5">
            <i class="bi bi-save me-2"></i> Simpan Pengaturan
        </button>
    </div>
</form>

<script>
// Form submit loading state
document.getElementById('settingsForm').addEventListener('submit', function() {
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
});
</script>

<?= $this->endSection() ?>
