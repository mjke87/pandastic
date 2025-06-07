<article>
    <header>
        <h2><?= htmlspecialchars($reward->title) ?></h2>
    </header>
    <p><?= nl2br(htmlspecialchars($reward->description ?? '')) ?></p>
    <p>Cost: <strong><?= htmlspecialchars($reward->value ?? 0) ?></strong> Bambux</p>
    <p>Status:
        <?php if ($reward->approved): ?>
            <span style="color:blue;">Approved</span>
        <?php elseif ($reward->is_claimed): ?>
            <span style="color:orange;">Claimed</span>
        <?php else: ?>
            <span>Available</span>
        <?php endif; ?>
    </p>
    <?php if (user_can('edit rewards') || user_can('delete rewards')): ?>
        <footer>
            <nav>
                <ul>
                    <?php if (user_can('edit rewards')): ?>
                        <li>
                            <a href="<?= url('reward.edit', $reward) ?>"><button>Edit</button></a>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul>
                    <?php if (user_can('delete rewards')): ?>
                        <li>
                            <form method="post" action="<?= url('reward.destroy', $reward) ?>">
                                <a href=" #" onclick="event.preventDefault(); if(confirm('Delete this reward?')) this.closest('form').submit();" role="delete">Delete</a>
                                <input type="hidden" name="_method" value="DELETE">
                            </form>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </footer>
    <?php endif; ?>
</article>