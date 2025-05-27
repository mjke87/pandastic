<h2>Hi, <?= htmlspecialchars($user->name ?? $user->username ?? '') ?></h2>

<article>
    <header>
        <h3>Your Progress</h3>
    </header>
    <section>
        <progress value="<?= $progress ?>" max="<?= $goal ?>" style="height:3rem;"></progress>
        <p><?= $progress ?> / <?= $goal ?> grades achieved (<?= $percent ?>%)</p>
        <form method="post" action="/set-goal" style="margin-top:1em;">
            <label for="goal">Set your grade goal:</label>
            <input type="number" name="goal" id="goal" min="1" value="<?= htmlspecialchars($goal) ?>">
            <button type="submit">Update Goal</button>
        </form>
    </section>
</article>

<article>
    <header>
        <h3>Your Grades</h3>
    </header>
    <section>
    <?php if (empty($grades)): ?>
        <p>No grades yet.</p>
    <?php else: ?>
        <?php foreach ($grades as $grade): ?>
            <?php render_view('grade.card', ['grade' => $grade]); ?>
        <?php endforeach; ?>
    <?php endif; ?>
    </section>
</article>