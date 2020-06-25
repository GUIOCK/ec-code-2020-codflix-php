<?php ob_start();
  $media = Media::getMediaById($_GET['media']);?>

  <div class="media-list">
    <div class="row">
      <h3><?php $media->getTitle()?></h3>
    </div>
  </div>


<?php $content = ob_get_clean(); ?>

<?php require('dashboard.php'); ?>