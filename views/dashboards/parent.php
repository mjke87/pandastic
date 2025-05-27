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
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($children as $child): ?>
                        <tr>
                            <td><?= htmlspecialchars($child['user']->name ?? $child['user']->username) ?></td>
                            <td><progress value="<?= $child['percent'] ?>" max="100" style="height: 1rem; margin-bottom: 0;"></progress></td>
                            <td><?= $child['progress'] ?> / <?= $child['goal'] ?> grades</td>
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
                                    <td><?= htmlspecialchars($grade->date) ?></td>
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