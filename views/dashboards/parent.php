<h2>Hi, <?= htmlspecialchars($user->name ?? $user->username ?? '') ?></h2>

<article>
    <header>
        <h3>Progress</h3>
    </header>
    <div>
        <?php if (empty($children)): ?>
            <p>No children found.</p>
        <?php else: ?>
            <p>Your children are working pandasticly towards their goals!</p>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Progress</th>
                        <th>&nbsp;</th>
                        <th>Goal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($children as $child): ?>
                        <tr>
                            <td><?= htmlspecialchars($child['user']->name ?? $child['user']->username) ?></td>
                            <td>
                                <progress value="<?= $child['funds'] ?>" max="<?= $child['goal'] ?>" style="height: 1rem; margin-bottom: 0;"></progress>
                                <?= config('app.currency') ?><?= number_format($child['funds'], 2) ?> / <?= config('app.currency') ?><?= number_format($child['goal'], 2) ?>
                                (<?= $child['percent'] ?>%)
                            </td>
                            <td>
                                <?php if (!empty($child['goal_name'])): ?>
                                    <?= htmlspecialchars($child['goal_name']) ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= config('app.currency') ?><?= number_format($child['goal'], 2) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</article>

<article>
    <header>
        <h3>Grades</h3>
    </header>
    <div>
        <?php if (empty($children)): ?>
            <p>No grades to show.</p>
        <?php else: ?>
            <p>Here you can see the grades your children have received:</p>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Grade</th>
                        <th>Subject</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($children as $child): ?>
                        <?php if (!empty($child['grades'])): ?>
                            <?php foreach ($child['grades'] as $grade): ?>
                                <tr>
                                    <td><?= htmlspecialchars($child['user']->name ?? $child['user']->username) ?></td>
                                    <td><?= htmlspecialchars($grade->grade) ?></td>
                                    <td><?= htmlspecialchars($grade->subject) ?></td>
                                    <td><?= format_date($grade->date) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td><?= htmlspecialchars($child['user']->name ?? $child['user']->username) ?></td>
                                <td colspan="3">No grades yet.</td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</article>