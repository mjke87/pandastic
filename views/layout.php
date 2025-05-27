<!DOCTYPE html>
<html lang="en" data-theme="<?= htmlspecialchars($theme ?? 'light') ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title><?php echo $title ?? config('app.name') ?></title>
    <?php if (!empty($css_framework)) : ?>
        <?php foreach ((array)$css_framework as $css): ?>
            <link rel="stylesheet" href="<?= htmlspecialchars($css) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <link rel="stylesheet" href="/public/css/style.css">
</head>

<body class="container">

    <header>
        <nav>
            <ul>
                <li><a href="/"><img src="/public/img/logo.png" alt="<?= config('app.name') ?>" class="logo" style="max-height: 50px;" /></a></li>
                <!--<li><strong><a href="/" class="contrast"><?= config('app.name') ?></a></strong></li>-->
            </ul>

            <?php render_view('nav.main'); ?>

            <?php render_view('nav.secondary'); ?>
        </nav>
    </header>

    <?php if (isset($_GET['success'])): ?>
        <article style="background: darkgreen">
            <p style="color: white;">Action completed successfully!</p>
        </article>
    <?php elseif (isset($_GET['error'])): ?>
        <article style="background: darkred">
            <p style="color: white;">An error occurred while processing your request.</p>
        </article>
    <?php endif; ?>

    <?php if (!empty($content)) : ?>
        <main>
            <?php echo $content ?? ''; ?>
        </main>
    <?php else : ?>
        <?php render_view('404'); ?>
    <?php endif; ?>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> <?= config('app.name') ?></p>
    </footer>

    <script src="/public/js/app.js"></script>
    <?php if (!empty($js_framework)): ?>
        <?php foreach ((array)$js_framework as $js): ?>
            <script src="<?= htmlspecialchars($js) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>

</html>