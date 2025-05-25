<article>
    <header>
        <h2><?= empty($user) ? 'Create User' : 'Edit User' ?></h2>
    </header>
    <?php if (!empty($message)): ?>
        <div><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="post" action="<?= empty($user) ? '/user' : '/user/' . htmlspecialchars($user->id ?? '') ?>">
        <div>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user->username ?? '') ?>" required>
        </div>
        <div>
            <label for="password"><?= empty($user) ? 'Password' : 'New Password (leave blank to keep current)' ?></label>
            <input type="password" id="password" name="password" <?= empty($user) ? 'required' : '' ?>>
        </div>
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($user->name ?? '') ?>" required>
        </div>
        <div>
            <label for="birthday">Birthday</label>
            <input type="date" id="birthday" name="birthday" value="<?= htmlspecialchars($user->birthday ?? '') ?>">
        </div>
        <div>
            <label for="current_funds">Funds (CHF)</label>
            <input type="number" id="current_funds" name="current_funds" step="0.01" value="<?= htmlspecialchars($user->current_funds ?? '0') ?>">
        </div>
        <div>
            <label for="multiplier">Multiplier</label>
            <input type="number" id="multiplier" name="multiplier" step="0.01" value="<?= htmlspecialchars($user->multiplier ?? '1') ?>">
        </div>
        <button type="submit" class="primary">Save</button>
        <a href="/users" class="secondary">Cancel</a>
        <?php if (!empty($user)): ?>
            <input type="hidden" name="_method" value="PUT">
        <?php endif; ?>
    </form>
</article>
