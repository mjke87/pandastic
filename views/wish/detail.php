<?= render_view('nav.breadcrumb', [
    'resource' => 'wish',
    'title' => htmlspecialchars($wish->title ?? ''),
]) ?>

<article>
    <header>
        <h2><?= htmlspecialchars($wish->title) ?></h2>
    </header>
    <p><?= nl2br(htmlspecialchars($wish->description ?? '')) ?></p>
    <p>Status:
        <?php if ($wish->is_fulfilled): ?>
            <span style="color:green;">Fulfilled</span>
        <?php else: ?>
            <span>Open</span>
        <?php endif; ?>
    </p>
    <?php if (user_can('edit wishes') || user_can('delete wishes')): ?>
    <footer>
        <nav>
            <ul>
                <?php if (user_can('edit wishes')): ?>
                    <li>
                        <a href="<?= url('wish.edit', $wish) ?>"><button>Edit</button></a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul>
                <?php if (user_can('delete wishes')): ?>
                    <li>
                        <form method="post" action="<?= url('wish.destroy', $wish) ?>" onsubmit="return confirm('Are you sure you want to delete this wish?');">
                            <a href="#" onclick="event.preventDefault(); if(confirm('Delete this wish?')) this.closest('form').submit();" role="delete">Delete</a>
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </footer>
    <?php endif; ?>
</article>
