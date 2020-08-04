<?php require('partials/header.php'); ?>
<h1>Update <?= $user[0]->name ?>'s name:</h1>
<div class="form-group">
	<form method="POST" action="/user/update/<?= $user[0]->user_id ?>">
        <input class="form-control" name="name"/>
	    <button class="form-control" type="submit">Submit</button>
	</form>
</div>
<h2>Viewing user <?= $user[0]->name ?></h2>
<ul>
    <li><?= $user[0]->user_id; ?> - <?= $user[0]->name; ?></li>
</ul>
<?php require ('partials/footer.php'); ?>
