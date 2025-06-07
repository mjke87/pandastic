<article>
    <a href="<?= url('reward.show', $reward) ?>" style="text-decoration:none;color:inherit">
        <header>
            <h3><?= htmlspecialchars($reward->title) ?></h3>
        </header>
        <div>
            Cost: <strong><?= htmlspecialchars($reward->value ?? 0) ?></strong> Bambux
            <?php if ($reward->is_claimed): ?>
                <span style="color:orange;">(Claimed)</span>
            <?php endif; ?>
            <?php if ($reward->approved): ?>
                <span style="color:blue;">(Approved)</span>
            <?php endif; ?>
        </div>
    </a>
</article>