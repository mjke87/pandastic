<nav>
    <ul>
        <li>
            <h2>Wishes</h2>
        </li>
    </ul>
    <ul>
        <?php if (user_can('create wishes')): ?>
            <li><a href="<?= url('wish.create') ?>" role="button"><?= icon('add') ?> Make a Wish</a></li>
        <?php endif; ?>
    </ul>
</nav>
<?php
foreach ($items as $wish) {
    render_view('wish.card', [
        'wish' => $wish,
    ]);
}
