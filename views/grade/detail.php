<nav aria-label="breadcrumb">
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/grades">Grades</a></li>
        <li><?= htmlspecialchars($grade->grade ?? '') ?></li>
    </ul>
</nav>

<article>
    <header>
        <h2><?= $grade->subject ?>: <?= htmlspecialchars($grade->grade) ?></h2>
    </header>
    <?php $username = $grade->user()->id == current_user()->id ? 'You' : htmlspecialchars($grade->user()->name ?? $grade->user()->username); ?>
    <p>
        <strong><?= $username ?></strong> scored a
        <strong><?= htmlspecialchars($grade->grade) ?></strong>
        in
        <strong><?= htmlspecialchars($grade->subject) ?></strong>
        on
        <?= format_date($grade->date) ?>
    <p>
    <p>
        For that grade <?= $username ?> earned
        <?= config('app.currency') ?>
        <strong><?= number_format($grade->reward(), 2) ?></strong>
        <?= icon('panda') ?>
    </p>
    <?php if (user_can('edit grades') || user_can('delete grades')): ?>
    <footer>
        <nav style="padding: 0 calc(var(--pico-block-spacing-horizontal)/2);">
            <ul>
                <?php if (user_can('edit grades')): ?>
                    <li>
                        <a href="/grade/edit/<?= htmlspecialchars($grade->id) ?>"><button><?= icon('edit') ?> Edit</button></a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul>
                <?php if (user_can('delete grades')): ?>
                    <li>
                        <form method="post" action="/grade/<?= htmlspecialchars($grade->id) ?>">
                            <a href="#" onclick="event.preventDefault(); if(confirm('Delete this grade?')) this.closest('form').submit();" role="delete">Delete</a>
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </footer>
    <?php endif; ?>
</article>