<nav>
    <ul>
        <li>
            <h2>Grades</h2>
        </li>
    </ul>
    <ul>
        <?php if (user_can('create grades')): ?>
            <li><a href="<?= url('grade.create') ?>" role="button"><?= icon('add') ?> Add Grade</a></li>
        <?php endif; ?>
    </ul>
</nav>
<?php
foreach ($items as $grade) {
    render_view('grade.card', [
        'grade' => $grade,
    ]);
}
