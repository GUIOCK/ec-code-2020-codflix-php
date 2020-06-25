<?php ob_start();
  $media = Media::getMediaById($_GET['media']);
  ?>
  
  <div class="row">
    <div class="col-md-4 offset-md-4">
      <h3><?php echo($media->getTitle())?></h3>
    </div>
  </div>
  <div class="row row-offset">
    <div class="col-md-8 offset-md-2">
      <?php echo($media->getSummary())?>
    </div>
  </div>
  <?php
    if($media->getType() == "movie"):
     echo('
       <div class="row">
         <div class="col-md-12">
           <iframe frameborder="0" style="height: 200%; width: 100%; margin-bottom:50px" src="' . $media->getContent() . '"></iframe>
         </div>
       </div>
     ');
    else:
      echo('
        <div class="row row-offset">
          <h5> Saison n°'.$media->getContent()[0]["seasonNumber"].'</h5>
        </div>
      ');
      for($episode = 0; $episode < count($media->getContent()) - 1; $episode++):
        $rowContent = $media->getContent()[$episode];
        echo('
          <div class="row">
            <div class="col-md-4">
              '.$rowContent["episodeNumber"] . ' : ' . $rowContent["episodeTitle"] . '
            </div>
            <div class="col-md-8">
              <iframe frameborder="0" src="' . $rowContent["contentURL"] . '"></iframe>
            </div>
          </div>
        ');
        $nextEpisode = $media->getContent()[$episode+1]["seasonNumber"];
        if(
          $nextEpisode != null &&
          !empty($nextEpisode) &&
          is_numeric($nextEpisode) &&
          $nextEpisode != $rowContent["seasonNumber"]):
          echo('
            <div class="row row-offset">
              <h5> Saison n°'.$media->getContent()[$episode+1]["seasonNumber"].'</h5>
            </div>
          ');
        endif;
      endfor;
    endif;
      ?>


<?php $content = ob_get_clean(); ?>

<?php require('dashboard.php'); ?>