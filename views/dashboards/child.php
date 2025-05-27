<h2>Hi, <?= htmlspecialchars($user->name ?? $user->username ?? '') ?></h2>

<article>
    <header>
        <h3>Your Progress</h3>
    </header>
    <div>
        <p>
            You are doing <strong>pandastic</strong>! Keep up the good work!
            <?= icon('panda') ?>
        </p>
        <progress value="<?= $funds ?>" max="<?= $goal ?>" style="height:3rem;"></progress>
        <p>
            <?= config('app.currency') ?><?= number_format($funds, 2) ?> / <?= config('app.currency') ?><?= number_format($goal, 2) ?>
            (<?= $percent ?>%)
            <?php if (!empty($goal_name)): ?>
                <br>Goal: <strong><?= htmlspecialchars($goal_name) ?></strong>
            <?php endif; ?>
        </p>
    </div>
</article>

<article>
    <header>
        <h3>Your Grades</h3>
    </header>
    <div class="grid" data-columns="4">
        <?php if (empty($grades)): ?>
            <p>No grades yet.</p>
        <?php else: ?>
            <?php foreach ($grades as $grade): ?>
                <?php render_view('grade.card', ['grade' => $grade]); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</article>

<article>
    <header>
        <h3>Your Funding Goal</h3>
    </header>
    <form method="post" action="/set-goal" style="margin-top:1em;">
        <label for="goal">Set your funding goal:</label>
        <input type="number" name="goal" id="goal" min="1" step="0.01" value="<?= htmlspecialchars($goal) ?>">
        <label for="goal_name">Goal name (e.g. "New Phone"):</label>
        <input type="text" name="goal_name" id="goal_name" value="<?= htmlspecialchars($goal_name) ?>">
        <button type="submit">Update Goal</button>
    </form>
</article>