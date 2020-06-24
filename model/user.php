<?php

require_once( 'database.php' );
require( 'Language.php' );

class User {

  protected $id;
  protected $email;
  protected $password;
  protected $validationHash;
  protected $isValidated;

  public function __construct( $user = null ) {

    if( $user != null ):
      $this->setId( isset( $user->id ) ? $user->id : null );
      $this->setEmail( $user->email );
      $this->setPassword( $user->password, isset( $user->password_confirm ) ? $user->password_confirm : false );
    endif;
  }

  /***************************
  * -------- SETTERS ---------
  ***************************/

  public function setId( $id ) {
    $this->id = $id;
  }

  public function setValidationHash( $validationHash ){
    $this->validationHash = $validationHash;
  }

  public function setIsValidated( $isValidated = true ){
    $db = init_db();
    $req = $db->prepare( "UPDATE `user` SET `isValidated` = '$isValidated' WHERE `user`.`id` = ?" );
    $req->execute( array( $this->getId() ) );
    $db = null;
  }

  public function setEmail( $email ) {

    if ( !filter_var($email, FILTER_VALIDATE_EMAIL)):
      throw new Exception( Language::$fr['SignupInvalidEmail'] );
    endif;

    $this->email = $email;

  }

  public function setPassword( $password, $password_confirm = false ) {

    if( $password_confirm && $password != $password_confirm ):
      throw new Exception( Language::$fr['SignupDifferentPassword'] );
    endif;
    $hashedPassword = hash("sha256", $password);
    $this->password = $hashedPassword;
  }

  /***************************
  * -------- GETTERS ---------
  ***************************/
  
  public function getId() {
    if(!isset($this->id) || $this->id == null || empty($this->id)):
      $db = init_db();
      $req = $db->prepare( "SELECT id FROM user WHERE email = ?" );
      $req->execute( array( $this->email ) );
      $this->id = $req->fetch()[0];
      $db = null;
    endif;
    return $this->id;
  }

  public function getEmail() {
    return $this->email;
  }

  public function getPassword() {
    return $this->password;
  }

  public function getValidationHash() {
    return $this->validationHash;
  }
  public function getIsValidated(){
    return $this->isValidated;
  }

  /***********************************
  * -------- CREATE NEW USER ---------
  ************************************/

  public function createUser() {

    // Open database connection
    $db   = init_db();

    // Check if email already exist
    $req  = $db->prepare( "SELECT * FROM user WHERE email = ?" );
    $req->execute( array( $this->getEmail() ) );

    if( $req->rowCount() > 0 ) throw new Exception( Language::$fr["SignupExistingEmail"] );

    // Insert new user
    $req->closeCursor();

    $req  = $db->prepare( "INSERT INTO user ( email,validationHash, password ) VALUES ( :email, :validationHash, :password )" );
    $req->execute( array(
      'email'          => $this->getEmail(),
      'validationHash' => $this->createValidationHash(),
      'password'       => $this->getPassword()
    ));

    // Close databse connection
    $db = null;

  }

  /**************************************
  * -------- GET USER DATA BY ID --------
  ***************************************/

  public static function getUserById( $id ) {

    // Open database connection
    $db   = init_db();

    $req  = $db->prepare( "SELECT * FROM user WHERE id = ?" );
    $req->execute( array( $id ));
    ///TODO: Transform array into user object
    // Close databse connection
    $db   = null;

    return $req->fetch();
  }

  /***************************************
  * ------- GET USER DATA BY EMAIL -------
  ****************************************/

  public function getUserByEmail() {

    // Open database connection
    $db   = init_db();

    $req  = $db->prepare( "SELECT * FROM user WHERE email = ?" );
    $req->execute( array( $this->getEmail() ));

    // Close databse connection
    $db   = null;
    return $req->fetch();
  }

  /****************************************
   * ------CREATE NEW VALIDATION HASH-------
   ****************************************/

  private function createValidationHash(){
    $this->validationHash = hash('sha256', rand( 0,1000 ) );
    return $this->validationHash;
  }
}
