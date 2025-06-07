<article>
    <header>
        <h2><?= !$grade->exists() ? 'Create Grade' : 'Edit Grade' ?></h2>
    </header>
    <?php if (!empty($error)): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
        <ul>
            <?php foreach ($fields as $field): ?>
                <li><?= htmlspecialchars($field) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form method="post" action="<?= !$grade->exists() ? url('grade.store') : url('grade.update', $grade) ?>">
        <div>
            <label for="grade">Grade</label>
            <input type="text" id="grade" name="grade" required value="<?= htmlspecialchars($grade->grade ?? '') ?>">
        </div>
        <div>
            <label for="date">Date</label>
            <input type="date" id="date" name="date" value="<?= htmlspecialchars($grade->date ?? date('Y-m-d')) ?>">
        </div>
        <div>
            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject" required value="<?= htmlspecialchars($grade->subject ?? '') ?>">
        </div>
        <?php if (user_can('manage users')): ?>
            <div>
                <label for="user_id">Child</label>
                <select id="user_id" name="user_id" required>
                    <option value="">Select a child</option>
                    <?php foreach (\App\Models\User::withRole(\App\Models\Role::Child) as $child): ?>
                        <option value="<?= $child->id ?>" <?= $grade->user_id == $child->id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($child->name ?? $child->username) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>
        <div>
            <label for="reward">Reward (<?= config('app.currency') ?>)</label>
            <input type="number" id="reward" name="reward"
                value="<?= htmlspecialchars($grade->reward() ?? '') ?>">
        </div>
        <button type="submit" class="primary"><?= !$grade->exists() ? 'Create' : 'Save' ?></button>
        <?php if ($grade->exists()): ?>
            <a href="<?= url('grade.show', $grade) ?>" class="secondary">Cancel</a>
            <input type="hidden" name="_method" value="PUT">
        <?php else: ?>
            <a href="<?= url('grade.index') ?>" class="secondary">Cancel</a>
        <?php endif; ?>
    </form>
</article>