<article>
    <a href="<?= url('wish.show', $wish) ?>" style="text-decoration:none;color:inherit">
        <header>
            <h3><?= htmlspecialchars($wish->title) ?></h3>
        </header>
        <div>
            <?php if ($wish->is_fulfilled): ?>
                <span style="color:green;">(Fulfilled)</span>
            <?php endif; ?>
        </div>
    </a>
</article>