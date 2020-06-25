<?php

require_once( 'model/media.php' );

/***************************
* ----- LOAD HOME PAGE -----
***************************/

function mediaPage() {

  $search = isset( $_GET['title'] ) ? $_GET['title'] : null;
  if($search != null):
    ///TODO: search function implementation
  else:
    $medias = Media::filterMedias( $search );
  endif;
  if(!isset($_GET['media'])):
    require('view/mediaListView.php');
  else:
    require('view/detailMedia.php');
  endif;
}
