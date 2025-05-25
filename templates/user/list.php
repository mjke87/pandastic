<a href="/user/create" class="btn btn-primary" style="margin-bottom: 1em;">Create User</a>
<?php
foreach ($users as $user) {
    Flight::render('user/card.php', [
        'user' => $user,
    ]);
}
