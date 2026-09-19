<header class="main-header">
    <div class="header-left">
        <!-- Toggle Button for Mobile -->
        <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
            <i class="bi bi-list"></i>
        </button>
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <?php $breadcrumbs = getBreadcrumb(); ?>
                <?php foreach ($breadcrumbs as $index => $breadcrumb): ?>
                    <?php if ($breadcrumb['active']): ?>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= esc($breadcrumb['title']) ?>
                        </li>
                    <?php else: ?>
                        <li class="breadcrumb-item">
                            <a href="<?= esc($breadcrumb['url']) ?>">
                                <?= esc($breadcrumb['title']) ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ol>
        </nav>
    </div>
    
    <div class="header-right">
        <!-- User Menu -->
        <div class="user-menu">
            <div class="user-info" id="userMenuToggle">
                <div class="user-avatar" <?php if(session()->get('user_avatar')) echo 'style="padding: 0; overflow: hidden; background: transparent;"'; ?>>
                    <?php if (session()->get('user_avatar')) : ?>
                        <img src="<?= base_url('uploads/avatars/' . session()->get('user_avatar')) ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                    <?php else : ?>
                        <?= getUserInitial(session()->get('user_name')) ?>
                    <?php endif; ?>
                </div>
                <div class="user-details">
                    <span class="user-name"><?= esc(session()->get('user_name') ?? 'Administrator') ?></span>
                    <span class="user-role"><?= ucfirst(esc(session()->get('user_role') ?? 'admin')) ?></span>
                </div>
                <i class="bi bi-chevron-down user-dropdown-icon"></i>
            </div>
            
            <!-- Dropdown Menu -->
            <div class="user-dropdown" id="userDropdown">
                <a href="<?= base_url('admin/profile') ?>">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?= base_url('auth/logout') ?>">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </div>
</header>
