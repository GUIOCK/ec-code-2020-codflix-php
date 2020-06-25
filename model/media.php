<?php

require_once( 'database.php' );

class Media {

  protected $id;
  protected $genre_id;
  protected $title;
  protected $type;
  protected $status;
  protected $release_date;
  protected $summary;
  protected $trailer_url;
	protected $content;
  
  public function __construct( $media = null) {

    $this->setId( isset( $media->id ) ? $media->id : null );
    if($media != null):
      $this->setGenreId( $media->genre_id );
      $this->setTitle( $media->title );
    endif;
  }

  /***************************
  * -------- SETTERS ---------
  ***************************/
	
  public function setId( $id ) {
    $this->id = $id;
  }

  public function setGenreId( $genre_id ) {
    $this->genre_id = $genre_id;
  }

  public function setTitle( $title ) {
    $this->title = $title;
  }

  public function setType( $type ) {
    $this->type = $type;
  }

  public function setStatus( $status ) {
    $this->status = $status;
  }

  public function setReleaseDate( $release_date ) {
    $this->release_date = $release_date;
  }

  public function  setSummary( $summary ){
    $this->summary = $summary;
  }

  public function setTrailerURL( $trailer_url ){
    $this->trailer_url = $trailer_url;
  }
  
  public function setContent(){
  
		$db = init_db();
		$req  = $db->prepare( "SELECT * FROM media_content WHERE media_id = ? ORDER BY season_number, episode_number ASC" );
		$req->execute( array( $this->getId() ));
	  $contentData = $req->fetchAll();
	  if($this->getType() == 'movie'):
	    $this->content = $contentData[0]['content_url'];
	  else:
		  $this->content = array();
		  for ($i = 0; $i < count($contentData); $i++):
	      $this->content[$i]['episodeTitle'] = $contentData[$i]['episode_title'];
	      $this->content[$i]['seasonNumber'] = $contentData[$i]['season_number'];
	      $this->content[$i]['episodeNumber'] = $contentData[$i]['episode_number'];
	      $this->content[$i]['contentURL'] = $contentData[$i]['content_url'];
	    endfor;
	  endif;
  }

  /***************************
  * -------- GETTERS ---------
  ***************************/

  public function getId() {
    return $this->id;
  }

  public function getGenreId() {
    return $this->genre_id;
  }

  public function getTitle() {
    return $this->title;
  }

  public function getType() {
    return $this->type;
  }

  public function getStatus() {
    return $this->status;
  }

  public function getReleaseDate() {
    return $this->release_date;
  }

  public function getSummary() {
    return $this->summary;
  }

  public function getTrailerUrl() {
    return $this->trailer_url;
  }
  
  public function getContent(){
  	return $this->content;
  }

  public static function  getMediaById( $id ){
    $db   = init_db();

    $req  = $db->prepare( "SELECT * FROM media WHERE id = ?" );
    $req->execute( array( $id ));

    // Close databse connection
    $db   = null;

    $mediaData = $req->fetch();
    $media = new Media();
    $media->setid($mediaData['id']);
    $media->setGenreId($mediaData['genre_id']);
    $media->setTitle($mediaData['title']);
    $media->setType($mediaData['type']);
    $media->setStatus($mediaData['status']);
    $media->setReleaseDate($mediaData['release_date']);
    $media->setSummary($mediaData['summary']);
    $media->setTrailerUrl($mediaData['trailer_url']);
    $media->setContent();
    return $media;
  }

  /***************************
  * -------- GET LIST --------
  ***************************/

  public static function filterMedias( $title ) {

    // Open database connection
    $db   = init_db();

    $req  = $db->prepare( "SELECT * FROM media WHERE title = ? ORDER BY release_date DESC" );
    $req->execute( array( '%' . $title . '%' ));

    // Close databse connection
    $db   = null;

    return $req->fetchAll();

  }

  public static function getMediasArray($orderBy = "release_date", $isAsc = false) {
    $db = init_db();

    $req = $db->prepare("SELECT * FROM media ORDER BY :orderBy :order");
    $req->execute(array(
      "orderBy" => $orderBy,
      "order" => $isAsc ? 'ASC' : "DESC"
    ));
    $mediaData = $req->fetch();
    $medias = array();
    while(isset($mediaData) && $mediaData != null && !empty($mediaData)):
      $media = new Media();
      $media->setId($mediaData['id']);
      $media->setGenreId($mediaData['genre_id']);
      $media->setTitle($mediaData['title']);
      $media->setType($mediaData['type']);
      $media->setStatus($mediaData['status']);
      $media->setReleaseDate($mediaData['release_date']);
      $media->setSummary($mediaData['summary']);
      $media->setStatus($mediaData['status']);
      $media->setTrailerURL($mediaData['trailer_url']);
      array_push($medias,$media);
      $mediaData = $req->fetch();
    endwhile;
    return $medias;
  }

}
