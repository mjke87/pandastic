<a href="/grade/create" class="btn btn-primary" style="margin-bottom: 1em;">Create Grade</a>
<?php
foreach ($grades as $grade) {
    Flight::render('grade/card.php', [
        'grade' => $grade,
    ]);
}
