<?php require('partials/header.php'); ?>
<h1 class="<?= theme('text-white-75', 'text-dark') ?>">Submit A Name:</h1>
<div class="form-group">
	<form method="POST" action="/users">
        <input class="form-control <?= theme('bg-dark text-white-75','bg-white') ?>" name="name"/>
	    <button class="form-control <?= theme('bg-dark text-white-75','bg-white') ?>" type="submit">Submit</button>
	</form>
</div>
<ul>
    <?php foreach ($users as $user) : ?>
        <li class="<?= theme('text-white-75', 'text-dark') ?>"><?= $user->name; ?> - <a href="/user/<?= $user->user_id ?>" class="<?= theme('text-light', 'text-primary') ?>">U</a> - <a href="/user/delete/<?= $user->user_id ?>" class="<?= theme('text-light', 'text-primary') ?>">X</a></li>
    <?php endforeach; ?>
</ul>

<?= paginate('users', $page, $limit, $count); ?>

<?php require ('partials/footer.php'); ?>
