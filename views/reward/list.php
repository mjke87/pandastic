<nav>
    <ul>
        <li>
            <h2>Rewards</h2>
        </li>
    </ul>
    <ul>
        <?php if (user_can('create rewards')): ?>
            <li><a href="<?= url('reward.create') ?>" role="button"><?= icon('add') ?> Add Reward</a></li>
        <?php endif; ?>
    </ul>
</nav>
<?php
foreach ($items as $reward) {
    render_view('reward.card', [
        'reward' => $reward,
    ]);
}
