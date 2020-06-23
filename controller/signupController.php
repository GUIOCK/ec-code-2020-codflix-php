<?php

require_once( 'model/user.php' );

/****************************
* ----- LOAD SIGNUP PAGE -----
****************************/

function signupPage() {

  $user     = new stdClass();
  ///TODO: Use setter
  $user->id = isset( $_SESSION['user_id'] ) ? $_SESSION['user_id'] : false; 

  if( !$user->id ):
    require('view/auth/signupView.php');
    
  else:
    require('view/homeView.php');
  endif;

}

/***************************
* ----- SIGNUP FUNCTION -----
***************************/
function signupRegister( $datas ) {
  $user = new User();
  $user->setEmail($datas['email']);
  $user->setPassword($datas['password']);
  $user->createUser();
  ///TODO: Create header "inscription effectué, validation du mail en attente"
  require('view/homeView.php');
}