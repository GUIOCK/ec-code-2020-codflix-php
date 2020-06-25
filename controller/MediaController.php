<?php

require_once( 'model/media.php' );

/***************************
* ----- LOAD HOME PAGE -----
***************************/

function mediaPage() {

  $medias = isset( $_GET['title'] ) ? Media::filterMedias( $_GET['title'] ) : Media::getMediasArray();

  if(!isset($_GET['media'])):
    require('view/mediaListView.php');
  else:
    require('view/detailMedia.php');
  endif;
}
