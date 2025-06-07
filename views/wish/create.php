<h2>Make a Wish</h2>
<form method="POST" action="<?= url('wish.store') ?>">
    <input name="title" placeholder="Wish title" required />
    <textarea name="description" placeholder="Describe your wish"></textarea>
    <button type="submit">Submit Wish</button>
</form>
