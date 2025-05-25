<h2><?= $title ?? 'An Error Occurred' ?></h2>
<p><?php echo htmlspecialchars($message ?? 'Something went wrong.'); ?></p>
<p><a href="/">Go to Home</a></p>