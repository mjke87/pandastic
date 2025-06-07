<nav>
    <ul>
        <li>
            <h2>Chores</h2>
        </li>
    </ul>
    <ul>
        <?php if (user_can('create chores')): ?>
            <li><a href="<?= url('chore.create') ?>" role="button"><?= icon('add') ?> Add Chore</a></li>
        <?php endif; ?>
    </ul>
</nav>
<?php
foreach ($items as $chore) {
    render_view('chore.card', [
        'chore' => $chore,
    ]);
}
