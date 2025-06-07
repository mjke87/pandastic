<article>
    <a href="<?= url('user.show', $user) ?>" style="text-decoration:none;color:inherit">
        <header>
            <h3><?= htmlspecialchars($user->name ?? $user->username) ?></h3>
        </header>
    </a>
</article>
