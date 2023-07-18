<?php require('partials/header.php'); ?>
<h1 class="<?php echo theme('text-white-75', 'text-dark') ?>">Update <?php echo $user[0]->name ?>'s name:</h1>
<div class="form-group">
	<form method="POST" action="/user/update/<?php echo $user[0]->user_id ?>">
        <input class="form-control <?php echo theme('bg-dark text-white-75', 'bg-white') ?>" name="name"/>
	    <button class="form-control <?php echo theme('bg-dark text-white-75', 'bg-white') ?>" type="submit">Submit</button>
	</form>
</div>
<h2 class="<?php echo theme('text-white-75', 'text-dark') ?>">Viewing user <?php echo $user[0]->name ?></h2>
<ul>
    <li><?php echo $user[0]->user_id; ?> - <?php echo $user[0]->name; ?></li>
</ul>
<?php require ('partials/footer.php'); ?>
