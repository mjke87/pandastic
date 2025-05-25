<article>
    <a href="/user/<?= htmlspecialchars($user['id']) ?>" style="text-decoration:none;color:inherit">
        <header>
            <h3><?= htmlspecialchars($user['name'] ?? $user['username']) ?></h3>
        </header>
        <p>Funds: <?= config('app.currency') ?> <?= number_format($user['current_funds'] ?? 0, 2) ?></p>
    </a>
</article>
