<h2>Add Chore</h2>
<form method="POST" action="<?= url('chore.store') ?>">
    <input name="title" placeholder="Chore title" required />
    <textarea name="description" placeholder="Describe the chore"></textarea>
    <input name="value" type="number" placeholder="Bambux reward" required />
    <button type="submit">Add Chore</button>
</form>
