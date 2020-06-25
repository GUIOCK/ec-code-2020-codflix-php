<?php

require_once( 'model/media.php' );

/***************************
* ----- LOAD HOME PAGE -----
***************************/

function mediaPage() {

  $search = isset( $_GET['title'] ) ? $_GET['title'] : null;
  
    $medias = Media::filterMedias( $search );
  if(!isset($_GET['media'])):
    require('view/mediaListView.php');
  else:
    require('view/detailMedia.php');
  endif;
}
