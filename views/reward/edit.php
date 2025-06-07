<article>
    <header>
        <h2><?= !$reward->exists() ? 'Add Reward' : 'Edit Reward' ?></h2>
    </header>
    <?php if (!empty($error)): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
        <ul>
            <?php foreach ($fields as $field): ?>
                <li><?= htmlspecialchars($field) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form method="post" action="<?= !$reward->exists() ? url('reward.store') : url('reward.update', $reward) ?>">
        <div>
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required value="<?= htmlspecialchars($reward->title ?? '') ?>">
        </div>
        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description"><?= htmlspecialchars($reward->description ?? '') ?></textarea>
        </div>
        <div>
            <label for="value">Bambux Cost</label>
            <input type="number" id="value" name="value" required value="<?= htmlspecialchars($reward->value ?? 0) ?>">
        </div>
        <button type="submit" class="primary"><?= !$reward->exists() ? 'Add Reward' : 'Save' ?></button>
        <?php if ($reward->exists()): ?>
            <a href="<?= url('reward.show', $reward) ?>" class="secondary">Cancel</a>
            <input type="hidden" name="_method" value="PUT">
        <?php else: ?>
            <a href="<?= url('reward.index') ?>" class="secondary">Cancel</a>
        <?php endif; ?>
    </form>
</article>
