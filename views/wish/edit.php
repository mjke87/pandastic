<article>
    <header>
        <h2><?= !$wish->exists() ? 'Make a Wish' : 'Edit Wish' ?></h2>
    </header>
    <?php if (!empty($error)): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
        <ul>
            <?php foreach ($fields as $field): ?>
                <li><?= htmlspecialchars($field) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form method="post" action="<?= !$wish->exists() ? url('wish.store') : url('wish.update', $wish) ?>">
        <div>
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required value="<?= htmlspecialchars($wish->title ?? '') ?>">
        </div>
        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description"><?= htmlspecialchars($wish->description ?? '') ?></textarea>
        </div>
        <?php if (user_can('manage users')): ?>
            <div>
                <label for="user_id">Child</label>
                <select id="user_id" name="user_id" required>
                    <option value="">Select a child</option>
                    <?php foreach (\App\Models\User::withRole(\App\Models\Role::Child) as $child): ?>
                        <option value="<?= $child->id ?>" <?= $wish->user_id == $child->id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($child->name ?? $child->username) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>
        <button type="submit" class="primary"><?= !$wish->exists() ? 'Make Wish' : 'Save' ?></button>
        <?php if ($wish->exists()): ?>
            <a href="<?= url('wish.show', $wish) ?>" class="secondary">Cancel</a>
            <input type="hidden" name="_method" value="PUT">
        <?php else: ?>
            <a href="<?= url('wish.index') ?>" class="secondary">Cancel</a>
        <?php endif; ?>
    </form>
</article>
