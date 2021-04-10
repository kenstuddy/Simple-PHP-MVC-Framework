<?php require('partials/header.php'); ?>
<h1 class="text-dark">Update <?= $user[0]->name ?>'s name:</h1>
<div class="form-group">
	<form method="POST" action="/user/update/<?= $user[0]->user_id ?>">
        <input class="form-control bg-white" name="name"/>
	    <button class="form-control bg-white" type="submit">Submit</button>
	</form>
</div>
<h2 class="text-dark">Viewing user <?= $user[0]->name ?></h2>
<ul>
    <li><?= $user[0]->user_id; ?> - <?= $user[0]->name; ?></li>
</ul>
<?php require ('partials/footer.php'); ?>
