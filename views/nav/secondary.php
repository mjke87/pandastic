<ul>
    <li>
        <a href="#" class="secondary" id="toggle-color-scheme" aria-label="Toggle Color Scheme">☀️</a>
    </li>
    <?php if (user_can('loggedIn')): ?>
        <li>
            <a href="<?= url('logout') ?>" class="secondary" aria-label="Logout">Logout</a>
        </li>
    <?php endif; ?>
</ul>
