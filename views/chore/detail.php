<article>
    <header>
        <h2><?= htmlspecialchars($chore->title) ?></h2>
    </header>
    <p><?= nl2br(htmlspecialchars($chore->description ?? '')) ?></p>
    <p>Reward: <strong><?= htmlspecialchars($chore->value ?? 0) ?></strong> Bambux</p>
    <p>Status:
        <?php if ($chore->approved): ?>
            <span style="color:blue;">Approved</span>
        <?php elseif ($chore->is_done): ?>
            <span style="color:green;">Done</span>
        <?php else: ?>
            <span>Open</span>
        <?php endif; ?>
    </p>
    <?php if (user_can('edit chores') || user_can('delete chores')): ?>
    <footer>
        <nav>
            <ul>
                <?php if (user_can('edit chores')): ?>
                    <li>
                        <a href="<?= url('chore.edit', $chore) ?>"><button>Edit</button></a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul>
                <?php if (user_can('delete chores')): ?>
                    <li>
                        <form method="post" action="<?= url('chore.destroy', $chore) ?>">
                            <a href="#" onclick="event.preventDefault(); if(confirm('Delete this chore?')) this.closest('form').submit();" role="delete">Delete</a>
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </footer>
    <?php endif; ?>
</article>
