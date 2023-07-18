<?php require('partials/header.php'); ?>
<h1 class="<?php echo theme('text-white-75', 'text-dark') ?>">Submit A Name:</h1>
<div class="form-group">
	<form method="POST" action="/users">
        <input class="form-control <?php echo theme('bg-dark text-white-75','bg-white') ?>" name="name"/>
	    <button class="form-control <?php echo theme('bg-dark text-white-75','bg-white') ?>" type="submit">Submit</button>
	</form>
</div>
<ul>
    <?php foreach ($users as $user) : ?>
        <li class="<?php echo theme('text-white-75', 'text-dark') ?>"><?php echo $user->name; ?> - <a href="/user/<?php echo $user->user_id ?>" class="<?php echo theme('text-light', 'text-primary') ?>">U</a> - <a href="/user/delete/<?php echo $user->user_id ?>" class="<?php echo theme('text-light', 'text-primary') ?>">X</a></li>
    <?php endforeach; ?>
</ul>

<?php echo paginate('users', $page, $limit, $count); ?>

<?php require ('partials/footer.php'); ?>
