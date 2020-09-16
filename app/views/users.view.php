<?php require('partials/header.php'); ?>
<h1>Submit A Name:</h1>
<div class="form-group">
	<form method="POST" action="/users">
        <input class="form-control" name="name"/>
	    <button class="form-control" type="submit">Submit</button>
	</form>
</div>
<ul>
    <?php foreach ($users as $user) : ?>
        <li><?= $user->name; ?> - <a href="/user/<?= $user->user_id ?>">U</a> - <a href="/user/delete/<?= $user->user_id ?>">X</a></li>
    <?php endforeach; ?>
</ul>

<?= paginate('users', $page, $limit, $count); ?>

<?php require ('partials/footer.php'); ?>
