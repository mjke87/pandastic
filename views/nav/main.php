<?php
$items = [
    'grades' => 'Grades',
    'users' => 'Users',
];
?>
<ul>
    <?php foreach ($items as $key => $name): ?>
        <?php if (user_can("manage $key")): ?>
            <li>
                <a href="/<?= htmlspecialchars($key) ?>"
                   <?php if (is_route('/' . rtrim($key, 's'), true)): ?>aria-current="true"<?php endif; ?>>
                   <?= htmlspecialchars($name) ?>
                </a>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
