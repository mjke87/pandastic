<nav aria-label="breadcrumb">
    <ul>
        <li><a href="<?= url('home') ?>">Home</a></li>
        <li><a href="<?= url("$resource.index") ?>"><?= __(ucfirst($resource)) ?></a></li>
        <li><?= htmlspecialchars($title ?? '') ?></li>
    </ul>
</nav>