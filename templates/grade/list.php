<nav>
    <ul>
        <li>
            <h2>Grades</h2>
        </li>
    </ul>
    <ul>
        <?php if (user_can('create grades')): ?>
            <li><a href="/grade/create" role="button">Add Grade</a></li>
        <?php endif; ?>
    </ul>
</nav>
<?php
foreach ($grades as $grade) {
    render_view('grade.card', [
        'grade' => $grade,
    ]);
}
