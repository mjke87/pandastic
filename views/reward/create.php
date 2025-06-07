<h2>Add Reward</h2>
<form method="POST" action="<?= url('reward.store') ?>">
    <input name="title" placeholder="Reward title" required />
    <textarea name="description" placeholder="Describe the reward"></textarea>
    <input name="value" type="number" placeholder="Bambux cost" required />
    <button type="submit">Add Reward</button>
</form>
