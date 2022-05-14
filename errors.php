<?php if (count($errors) > 0) : ?>
  <div class="error">
  	<?php foreach ($errors as $error) : ?>
  	  <p class="bg-danger p-3"><?php echo $error ?></p>
  	<?php endforeach ?>
  </div>
<?php endif ?>