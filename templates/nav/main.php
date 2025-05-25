<?php
$items = [
    'grades' => 'Grades',
    'users' => 'Users',
];
?>
<ul>
    <?php foreach ($items as $key => $name): ?>
        <?php if (user_can("view $key")): ?>
            <li><a href="/<?= htmlspecialchars($key) ?>" class="secondary"><?= htmlspecialchars($name) ?></a></li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
