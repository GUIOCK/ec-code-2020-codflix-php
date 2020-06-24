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
try
{
  $user->setPassword($datas['password'], $datas['password_confirm']);
  $user->createUser();
  $emailTo = $user->getEmail();
  $emailSubject = Language::$fr['VerifyEmailObject'];
  $emailLink = 'http://codflix/index.php?action=verify&id=' . $user->getId() . '&hash=' . $user->getValidationHash();
  //mail($mailTo,$mailSubject, Language::$fr['VerifyEmailBody'] . $emailLink);
  echo($emailLink);
  $_POST['error'] = Language::$fr['LoginWaitingConfirmationEmail'];
  require('view/auth/loginView.php');
}
catch (Exception $exception)
{
  $_POST['error'] = $exception->getMessage();
  require('view/auth/signupView.php');
}
  
}