<nav>
    <ul>
        <li>
            <h2>Users</h2>
        </li>
    </ul>
    <ul>
        <?php if (user_can('create users')): ?>
            <li><a href="<?= url('user.create') ?>" role="button">Create User</a></li>
        <?php endif; ?>
    </ul>
</nav>
<?php
foreach ($items as $user) {
    render_view('user.card', [
        'user' => $user,
    ]);
}
