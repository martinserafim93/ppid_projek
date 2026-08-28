<div class="breadcrumb-wrapper">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="bi bi-house-door me-1"></i>Beranda</a></li>
                <?php if (isset($breadcrumb) && is_array($breadcrumb)): ?>
                    <?php foreach ($breadcrumb as $item): ?>
                        <?php if (isset($item['active']) && $item['active']): ?>
                            <li class="breadcrumb-item active" aria-current="page"><?= esc($item['label']) ?></li>
                        <?php else: ?>
                            <li class="breadcrumb-item">
                                <?= isset($item['url']) ? '<a href="' . base_url($item['url']) . '">' . esc($item['label']) . '</a>' : esc($item['label']) ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ol>
        </nav>
    </div>
</div>
