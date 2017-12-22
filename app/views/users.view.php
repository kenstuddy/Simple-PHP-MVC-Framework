<?php require('partials/header.php'); ?>
<h1>Submit Your Name:</h1>
<div class="form-group">
	<form method="POST" action="/users">
	    <input class="form-control" name="name"></input>
	    <button class="form-control" type="submit">Submit</button>
	</form>
</div>
<ul>
    <?php foreach ($users as $user) : ?>
        <li><?= $user->name; ?></li>
    <?php endforeach; ?>
</ul>
<?php require ('partials/footer.php'); ?>
