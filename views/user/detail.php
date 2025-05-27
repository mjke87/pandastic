<nav aria-label="breadcrumb">
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/users">Users</a></li>
        <li><?= htmlspecialchars($user->username ?? '') ?></li>
    </ul>
</nav>

<article>
    <header>
        <h2>User Details</h2>
    </header>
    <?php if ($user): ?>
        <p>Username: <?= htmlspecialchars($user->username ?? '') ?></p>
        <p>Name: <?= htmlspecialchars($user->name ?? '') ?></p>
        <p>Birthday: <?= format_date($user->birthday ?? '') ?></p>
        <p>Multiplier: <?= htmlspecialchars($user->multiplier ?? 1) ?></p>
        <footer>
            <nav style="padding: 0 calc(var(--pico-block-spacing-horizontal)/2);">
                <ul>
                    <?php if (user_can('edit users')): ?>
                    <li>
                        <a href="/user/edit/<?= htmlspecialchars($user->id) ?>"><button>Edit</button></a>
                    </li>
                    <?php endif; ?>
                </ul>
                <ul>
                    <?php if (user_can('delete users')): ?>
                    <li>
                        <form method="post" action="/user/<?= htmlspecialchars($user->id) ?>" style="display:inline" class="delete-user-form">
                            <a href="#" onclick="event.preventDefault(); if(confirm('Delete user?')) this.closest('form').submit();" style="color: var(--pico-del-color)">Delete</a>
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </footer>
    <?php else: ?>
        <p>User not found.</p>
    <?php endif; ?>
</article>