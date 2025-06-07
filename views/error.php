<h2><?= $title ?? 'An Error Occurred' ?></h2>
<p><?= htmlspecialchars($message ?? 'Something went wrong.') ?></p>
<p><a href="<?= url('home') ?>">Go to Home</a></p>