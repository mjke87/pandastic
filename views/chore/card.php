<article>
    <a href="<?= url('chore.show', $chore) ?>" style="text-decoration:none;color:inherit">
        <header>
            <h3><?= htmlspecialchars($chore->title) ?></h3>
        </header>
        <div>
            Reward: <strong><?= htmlspecialchars($chore->value ?? 0) ?></strong> Bambux
            <?php if ($chore->is_done): ?>
                <span style="color:green;">(Done)</span>
            <?php endif; ?>
            <?php if ($chore->approved): ?>
                <span style="color:blue;">(Approved)</span>
            <?php endif; ?>
        </div>
    </a>
</article>