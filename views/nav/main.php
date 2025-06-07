<?php
$resources = [
    'grade' => 'Grades',
    'wish' => 'Wishes',
    'chore' => 'Chores',
    'reward' => 'Rewards',
    'transaction' => 'Bambux',
    'user' => 'Users',
];
?>
<ul>
    <?php foreach ($resources as $resource => $name): ?>
        <?php if (user_can('manage ' . pluralize($resource))): ?>
            <li>
                <?php $url = url("$resource.index"); ?>
                <a href="<?= $url ?>" <?php if (is_route($url, true)): ?>aria-current="true"<?php endif; ?>>
                   <?= htmlspecialchars($name) ?>
                </a>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
