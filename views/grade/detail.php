<article>
    <header>
        <h2><?= $grade->user()->name ?>: <?= htmlspecialchars($grade->grade) ?></h2>
    </header>
    <p>Subject: <?= htmlspecialchars($grade->subject) ?></p>
    <p>Date: <?= format_date($grade->date) ?></p>
    <footer>
        <nav style="padding: 0 calc(var(--pico-block-spacing-horizontal)/2);">
            <ul>
                <?php if (user_can('edit grades')): ?>
                <li>
                    <a href="/grade/edit/<?= htmlspecialchars($grade->id) ?>"><button class="icon-edit">Edit</button></a>
                </li>
                <?php endif; ?>
            </ul>
            <ul>
                <?php if (user_can('delete grades')): ?>
                <li>
                    <form method="post" action="/grade/<?= htmlspecialchars($grade->id) ?>" style="display:inline" class="delete-grade-form">
                        <a href="#" onclick="event.preventDefault(); if(confirm('Delete this grade?')) this.closest('form').submit();" style="color: var(--pico-del-color)">Delete</a>
                        <input type="hidden" name="_method" value="DELETE">
                    </form>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
    </footer>
</article>