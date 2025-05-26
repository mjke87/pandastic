<article>
    <a href="/grade/<?= htmlspecialchars($grade->id) ?>" style="text-decoration:none;color:inherit">
        <header>
            <h3><?= htmlspecialchars($grade->subject) ?> : <?= htmlspecialchars($grade->grade) ?></h3>
        </header>
        <section>
            <p><?= htmlspecialchars($grade->user()->name ?? $grade->user()->username) ?> scored a <?= $grade->grade ?> on <?= htmlspecialchars($grade->date) ?></p>
        <p></p>
    </a>
</article>
