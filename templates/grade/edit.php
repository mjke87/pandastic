<?php $grade = $grade ?? []; ?>
<article>
    <header>
        <?php if (empty($grade)): ?>
            <h2>Create Grade</h2>
        <?php else: ?>
            <h2>Edit Grade</h2>
        <?php endif; ?>
    </header>
    <?php if (!empty($error)): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="post" action="<?= empty($grade) ? '/grade' : '/grade/' . htmlspecialchars($grade['id']) ?>">
        <div>
            <label for="grade">Grade</label>
            <input type="text" id="grade" name="grade" required value="<?= htmlspecialchars($grade['grade'] ?? '') ?>">
        </div>
        <div>
            <label for="date">Date</label>
            <input type="date" id="date" name="date" value="<?= htmlspecialchars($grade['date'] ?? date('Y-m-d')) ?>">
        </div>
        <div>
            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject" required value="<?= htmlspecialchars($grade['subject'] ?? '') ?>">
        </div>
        <button type="submit" class="primary"><?= empty($grade) ? 'Create' : 'Save' ?></button>
        <?php if (!empty($grade)): ?>
            <a href="/grade/<?= htmlspecialchars($grade['id']) ?>" class="secondary">Cancel</a>
            <input type="hidden" name="_method" value="PUT">
        <?php else: ?>
            <a href="/grades" class="secondary">Cancel</a>
        <?php endif; ?>
    </form>
</article>
