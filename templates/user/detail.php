<nav aria-label="breadcrumb">
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/users">Users</a></li>
        <li><?= htmlspecialchars($user['username'] ?? '') ?></li>
    </ul>
</nav>

<article>
    <header>
        <h2>User Details</h2>
    </header>
    <?php if ($user): ?>
        <p>Username: <?= htmlspecialchars($user['username'] ?? '') ?></p>
        <p>Name: <?= htmlspecialchars($user['name'] ?? '') ?></p>
        <p>Birthday: <?= htmlspecialchars($user['birthday'] ?? '') ?></p>
        <p>Funds: CHF<?= number_format($user['current_funds'] ?? 0, 2) ?></p>
        <p>Multiplier: <?= htmlspecialchars($user['multiplier'] ?? 1) ?></p>
        <footer>
            <nav style="padding: 0 calc(var(--pico-block-spacing-horizontal)/2);">
                <ul>
                    <li>
                        <a href="/user/edit/<?= htmlspecialchars($user['id']) ?>"><button>Edit</button></a>
                    </li>
                </ul>
                <ul>
                    <li>
                        <form method="post" action="/user/<?= htmlspecialchars($user['id']) ?>" style="display:inline" class="delete-user-form">
                            <a href="#" onclick="event.preventDefault(); if(confirm('Delete user?')) this.closest('form').submit();" style="color: var(--pico-del-color)">Delete</a>
                            <input type="hidden" name="_method" value="DELETE">
                        </form>
                    </li>
                </ul>
            </nav>
        </footer>
    <?php else: ?>
        <p>User not found.</p>
    <?php endif; ?>
</article>