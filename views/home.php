<h2>Hi, <?= current_user()->name ?? '' ?></h2>
<p>You're doinig pandastic! Keep up the good work!</p>
<p><img src="<?= asset_url('img/panda-coin.jpg') ?>" alt="<?= config('app.name') ?>" style="max-width:300px;"/></p>