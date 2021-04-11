<?php require ('partials/header.php'); ?>
<h1 class="<?= theme('text-white-75','text-dark') ?>">Contact <?= $title ?></h1>
<p class="<?= theme('text-white-75','text-dark') ?>">If you'd like to contact <?= strtolower($title) ?>, please feel free to use my contact form on <a class="<?= theme('text-light', 'text-primary') ?>" href="<?= $website ?>"><?= $website ?></a> or email me at <a class="<?= theme('text-light', 'text-primary') ?>" href="mailto:<?= $email ?>"><?= $email ?></a></p>
<?php require ('partials/footer.php'); ?>
