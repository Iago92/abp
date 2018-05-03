<?php
// file: model/Post.php

require_once(__DIR__."/../core/ValidationException.php");

/**
 * Class Post
 *
 * Represents a Post in the blog. A Post was written by an
 * specific User (author) and contains a list of Comments
 *
 * @author lipido <lipido@gmail.com>
 */
class Session {

  private $id;
  /**
   * The id of this post
   * @var string
   */
  private $name;
  /**
   * The id of this post
   * @var string
   */


  /**
   * The title of this post
   * @var string
   */

  private $description_session;
  /**
   * The content of this post
   * @var string
   */
  private $id_user;

  /**
   * The author of this post
   * @var User
   */
  private $time;

  /**
   * The list of comments of this post
   * @var mixed
   */
  private $date;

  /**
   * The constructor
   *
   * @param string $id The id of the post
   * @param string $title The id of the post
   * @param string $content The content of the post
   * @param User $author The author of the post
   * @param mixed $comments The list of comments
   */
  public function __construct($name=NULL, $id=NULL, $description_session=NULL,  $time=NULL, $date=NULL, $id_user=NULL) {
    $this->name = $name;
    $this->id = $id;
    $this->description_session = $description_session;
    $this->time = $time;
    $this->date = $date;
    $this->id_user =$id_user;

  }
  /**
   * Gets the id of this post
   *
   * @return string The id of this post
   */
  public function getName() {
    return $this->name;
  }
  /**
   * Gets the id of this post
   *
   * @return string The id of this post
   */
  public function getId() {
    return $this->id;
  }

  public function getIdUser(){
	  return $this->id_user;
  }
  /**
   * Gets the title of this post
   *
   * @return string The title of this post
   */
  public function getDescription() {
    return $this->description_session;
  }
  /**
   * Gets the title of this post
   *
   * @return string The title of this post
   */
  public function getTime() {
    return $this->time;
  }
  /**
   * Gets the title of this post
   *
   * @return string The title of this post
   */
  public function getDate() {
    return $this->date;
  }

  /**
   * Gets the title of this post
   *
   * @return string The title of this post
   */
  public function getUser() {
    return $this->id_user;
  }
  /**
   * Sets the title of this post
   *
   * @param string $title the title of this post
   * @return void
   */
  public function setDescription($description_session) {
    $this->description_session = $description_session;
  }

  /**
   * Sets the title of this post
   *
   * @param string $title the title of this post
   * @return void
   */
  public function setTime($time) {
    $this->time = $time;
  }

  /**
   * Sets the title of this post
   *
   * @param string $title the title of this post
   * @return void
   */
  public function setDate($date) {
    $this->date = $date;
  }
    /**
   * Sets the title of this post
   *
   * @param string $title the title of this post
   * @return void
   */

  /**
   * Sets the title of this post
   *
   * @param string $title the title of this post
   * @return void
   */
  public function setName($name) {
    $this->name = $name;
  }
  public function setUser($id_user) {
    $this->id_user = $id_user;
  }
  /**
   * Checks if the current instance is valid
   * for being updated in the database.
   *
   * @throws ValidationException if the instance is
   * not valid
   *
   * @return void
   */
  public function checkIsValidForAdd() {
      $errors = array();
      if (strlen(trim($this->name)) == 0 ) {
  $errors["name"] = "name is mandator";
      }
      if (sizeof(trim($this->date)) < 0 ) {
	$errors["date"] = "date is mandator";
      }
      if (strlen(trim($this->description_session)) == 0 ) {
	$errors["description_session"] = "description_session is mandatory";
      }
      if (sizeof($errors) > 0){
	throw new ValidationException($errors, "post is not valid");
      }
  }

  /**
   * Checks if the current instance is valid
   * for being updated in the database.
   *
   * @throws ValidationException if the instance is
   * not valid
   *
   * @return void
   */
  public function checkIsValidForUpdate() {
    $errors = array();

    if (!isset($this->id)) {
      $errors["id"] = "id is mandatory";
    }

    try{
      $this->checkIsValidForAdd();
    }catch(ValidationException $ex) {
      foreach ($ex->getErrors() as $key=>$error) {
	$errors[$key] = $error;
      }
    }
    if (sizeof($errors) > 0) {
      throw new ValidationException($errors, "Session is not valid");
    }
  }
}
