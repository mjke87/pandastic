<article>
    <header>
        <h2>Hi, <?= htmlspecialchars($user->name ?? $user->username ?? '') ?></h2>
    </header>
    <section>
        <h3>Your Progress</h3>
        <progress value="<?= $progress ?>" max="<?= $goal ?>"></progress>
        <p><?= $progress ?> / <?= $goal ?> grades achieved (<?= $percent ?>%)</p>
        <form method="post" action="/set-goal" style="margin-top:1em;">
            <label for="goal">Set your grade goal:</label>
            <input type="number" name="goal" id="goal" min="1" value="<?= htmlspecialchars($goal) ?>">
            <button type="submit">Update Goal</button>
        </form>
    </section>
    <section>
        <h3>Your Grades</h3>
        <?php if (empty($grades)): ?>
            <p>No grades yet.</p>
        <?php else: ?>
            <?php foreach ($grades as $grade): ?>
                <?php render_view('grade.card', ['grade' => $grade]); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</article>
