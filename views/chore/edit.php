<article>
    <header>
        <h2><?= !$chore->exists() ? 'Add Chore' : 'Edit Chore' ?></h2>
    </header>
    <?php if (!empty($error)): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
        <ul>
            <?php foreach ($fields as $field): ?>
                <li><?= htmlspecialchars($field) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form method="post" action="<?= !$chore->exists() ? url('chore.store') : url('chore.update', ['id' => $chore->id]) ?>">
        <div>
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required value="<?= htmlspecialchars($chore->title ?? '') ?>">
        </div>
        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description"><?= htmlspecialchars($chore->description ?? '') ?></textarea>
        </div>
        <?php if (user_can('manage users')): ?>
            <div>
                <label for="user_id">Child</label>
                <select id="user_id" name="user_id" required>
                    <option value="">Select a child</option>
                    <?php foreach (\App\Models\User::withRole(\App\Models\Role::Child) as $child): ?>
                        <option value="<?= $child->id ?>" <?= $chore->user_id == $child->id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($child->name ?? $child->username) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>
        <div>
            <label for="value">Bambux Reward</label>
            <input type="number" id="value" name="value" required value="<?= htmlspecialchars($chore->value ?? 0) ?>">
        </div>
        <button type="submit" class="primary"><?= !$chore->exists() ? 'Add' : 'Save' ?></button>
        <?php if ($chore->exists()): ?>
            <a href="<?= url('chore.show', ['id' => $chore->id]) ?>" class="secondary">Cancel</a>
            <input type="hidden" name="_method" value="PUT">
        <?php else: ?>
            <a href="<?= url('chore.index') ?>" class="secondary">Cancel</a>
        <?php endif; ?>
    </form>
</article>
