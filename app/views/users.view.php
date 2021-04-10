<?php require('partials/header.php'); ?>
<h1 class="text-dark">Submit A Name:</h1>
<div class="form-group">
	<form method="POST" action="/users">
        <input class="form-control bg-white" name="name"/>
	    <button class="form-control bg-white" type="submit">Submit</button>
	</form>
</div>
<ul>
    <?php foreach ($users as $user) : ?>
        <li class="text-dark"><?= $user->name; ?> - <a href="/user/<?= $user->user_id ?>" class="text-primary">U</a> - <a href="/user/delete/<?= $user->user_id ?>" class="text-primary">X</a></li>
    <?php endforeach; ?>
</ul>

<?= paginate('users', $page, $limit, $count); ?>

<?php require ('partials/footer.php'); ?>
