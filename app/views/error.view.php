<?php require ('partials/header.php'); ?>
<h1 class="text-dark">An Error Has Occurred</h1>
<p class="text-dark">You have encountered an error. Please click <a href="/">here</a> to go to the home page.</p>
<?php if (isset($error)): ?>
    <?php echo $error; ?>
<?php endif; ?>
<?php require ('partials/footer.php'); ?>
