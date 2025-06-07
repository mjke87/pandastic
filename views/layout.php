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
</head>

<body class="container">

    <header>
        <nav>
            <ul>
                <li><a href="<?= url('home') ?>"><img src="<?= asset_url('img/logo.png') ?>" alt="<?= config('app.name') ?>" class="logo" style="max-height: 50px;" /></a></li>
                <!--<li><strong><a href="/" class="contrast"><?= config('app.name') ?></a></strong></li>-->
            </ul>

            <?php render_view('nav.main'); ?>

            <?php render_view('nav.secondary'); ?>
        </nav>
    </header>

    <?php if (isset($flash)): ?>
        <?php $color = match ($flash->type ?? 'info') {
            'success' => 'darkgreen',
            'error' => 'darkred',
            'warning' => 'darkorange',
            default => 'darkblue',
        }; ?>
        <article style="background: <?= $color ?>">
            <p style="color: white;"><?php echo htmlspecialchars($flash->message); ?></p>
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

    <?php if (!empty($js_framework)): ?>
        <?php foreach ((array)$js_framework as $js): ?>
            <script src="<?= htmlspecialchars($js) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>

</html>