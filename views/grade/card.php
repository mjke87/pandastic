<article>
    <a href="/grade/<?= htmlspecialchars($grade->id) ?>" style="text-decoration:none;color:inherit">
        <header>
            <h3><?= htmlspecialchars($grade->subject) ?> : <?= htmlspecialchars($grade->grade) ?></h3>
        </header>
        <div>
            <?php if ($grade->user()->id === current_user()->id): ?>
                <strong>You</strong>
            <?php else: ?>
                <strong><?= htmlspecialchars($grade->user()->name ?? $grade->user()->username) ?></strong>
            <?php endif; ?>
            scored a
            <strong><?= $grade->grade ?></strong>
            in
            <strong><?= htmlspecialchars($grade->subject) ?></strong>
            on
            <?= htmlspecialchars($grade->date) ?></p>
        </div>
    </a>
</article>
