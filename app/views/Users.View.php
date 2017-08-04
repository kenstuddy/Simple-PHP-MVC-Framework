<?php require('partials/header.php'); ?>
<ul>
    <?php foreach ($users as $user) : ?>
        <li><?= $user->name; ?></li>
    <?php endforeach; ?>
</ul>
<h1>Submit Your Name</h1>
<form method="POST" action="/users">
    <input name="name"></input>
    <button type="submit">Submit</button>
</form>
<?php require ('partials/footer.php'); ?>
