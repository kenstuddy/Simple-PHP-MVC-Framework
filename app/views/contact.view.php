<?php require ('partials/header.php'); ?>
<h1 class="<?php echo theme('text-white-75','text-dark') ?>">Contact <?php echo $title ?></h1>
<p class="<?php echo theme('text-white-75','text-dark') ?>">If you'd like to contact <?php echo strtolower($title) ?>, please feel free to use my contact form on <a class="<?php echo theme('text-light', 'text-primary') ?>" href="<?php echo $website ?>"><?php echo $website ?></a> or email me at <a class="<?php echo theme('text-light', 'text-primary') ?>" href="mailto:<?php echo $email ?>"><?php echo $email ?></a></p>
<?php require ('partials/footer.php'); ?>
