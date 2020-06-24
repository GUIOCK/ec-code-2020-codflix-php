<?php

session_start();

require_once( 'model/user.php' );

/****************************
* ----- LOAD LOGIN PAGE -----
****************************/

function loginPage() {

  $user     = new User();
  $user->setId(isset( $_SESSION['user_id'] ) ? $_SESSION['user_id'] : false);

  if( !$user->getId() ):
    require('view/auth/loginView.php');
  else:
    require('view/homeView.php');
  endif;

}

/***************************
* ----- LOGIN FUNCTION -----
***************************/

function login( $post ) {

  $data           = new stdClass();
  $data->email    = $post['email'];
  $data->password = $post['password'];

  $user           = new User( $data );
  $userData       = $user->getUserByEmail();

  if( $userData && sizeof( $userData ) != 0 && $user->getPassword() == $userData['password']):
    if($userData['isValidated']):
      // Set session
      $_SESSION['user_id'] = $userData['id'];
      header( 'location: index.php ');
    else:
      $_POST['error'] = Language::$fr['LoginWaitingConfirmationEmail'];
    endif;
  else:
    $_POST['error'] = Language::$fr['LoginWrongId'];
  endif;
    require('view/auth/loginView.php');
}

/****************************
* ----- LOGOUT FUNCTION -----
****************************/

function logout() {
  $_SESSION = array();
  session_destroy();

  header( 'location: index.php' );
}
