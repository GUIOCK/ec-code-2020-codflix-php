<?php
require_once( 'controller/homeController.php' );
require_once( 'controller/loginController.php' );
require_once( 'controller/signupController.php' );
require_once( 'controller/mediaController.php' );

/**************************
* ----- HANDLE ACTION -----
***************************/

if ( isset( $_GET['action'] ) ):

  switch( $_GET['action']):

    case 'login':

      if ( !empty( $_POST ) ) login( $_POST );
      else loginPage();

    break;

    case 'signup':
      if( empty( $_POST )):
        signupPage();
      else:
        signupRegister($_POST);
      endif;

    break;

    case 'verify':
      $userdata = User::getUserById($_GET['id']);
      $user = new User();
      $user->setId($_GET['id']);
      $user->setEmail($userdata["email"]);
      $user->setValidationHash($userdata["validationHash"]);

      if($user->getValidationHash() == $_GET['hash']):
        $user->setIsValidated(true);
        $_POST['error'] = Language::$fr['LoginConfirmedEmail'];
      else:
        $_POST['error'] = Language::$fr['LoginWrongConfirmationEmail'];
      endif;
      loginPage();

    break;


    case 'logout':

      logout();

    break;

  endswitch;

else:
  $user_id = isset( $_SESSION['user_id'] ) ? $_SESSION['user_id'] : false;

  if( $user_id ):
    mediaPage();
  else:
    homePage();
  endif;

endif;
