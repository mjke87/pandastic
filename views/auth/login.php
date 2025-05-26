<article>
    <header>
        <h2>Login</h2>
    </header>
    <?php if (!empty($message)): ?>
        <div><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="post" action="/login">
        <div>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="primary">Login</button>
    </form>
</article>
