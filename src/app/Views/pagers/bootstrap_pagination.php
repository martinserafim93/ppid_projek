<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Navigasi halaman">
    <ul class="pagination mb-0">
        <li class="page-item <?= $pager->hasPrevious() ? '' : 'disabled' ?>">
            <a class="page-link" href="<?= $pager->hasPrevious() ? $pager->getFirst() : '#' ?>" aria-label="Awal" <?= $pager->hasPrevious() ? '' : 'tabindex="-1"' ?>>
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <li class="page-item <?= $pager->hasPrevious() ? '' : 'disabled' ?>">
            <a class="page-link" href="<?= $pager->hasPrevious() ? $pager->getPrevious() : '#' ?>" aria-label="Sebelumnya" <?= $pager->hasPrevious() ? '' : 'tabindex="-1"' ?>>
                <span aria-hidden="true">&lsaquo;</span>
            </a>
        </li>

    <?php foreach ($pager->links() as $link) : ?>
        <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
            <a class="page-link" href="<?= $link['uri'] ?>"<?= $link['active'] ? ' aria-current="page"' : '' ?>>
                <?= $link['title'] ?>
            </a>
        </li>
    <?php endforeach ?>

        <li class="page-item <?= $pager->hasNext() ? '' : 'disabled' ?>">
            <a class="page-link" href="<?= $pager->hasNext() ? $pager->getNext() : '#' ?>" aria-label="Selanjutnya" <?= $pager->hasNext() ? '' : 'tabindex="-1"' ?>>
                <span aria-hidden="true">&rsaquo;</span>
            </a>
        </li>
        <li class="page-item <?= $pager->hasNext() ? '' : 'disabled' ?>">
            <a class="page-link" href="<?= $pager->hasNext() ? $pager->getLast() : '#' ?>" aria-label="Akhir" <?= $pager->hasNext() ? '' : 'tabindex="-1"' ?>>
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>
