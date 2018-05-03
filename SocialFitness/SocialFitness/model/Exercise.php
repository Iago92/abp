<?php
// file: model/User.php

require_once(__DIR__."/../core/ValidationException.php");

/**
 * Class User
 *
 * Represents a User in the blog
 *
 * @author lipido <lipido@gmail.com>
 */
class Exercise {

  /**
   * The id of this user
   * @var string
   */
  private $id;

  /**
   * The name of the user
   * @var string
   */
  private $name;

  /**
   * The type of the user
   * @var string
   */
  private $type;

  /**
   * The email of the user
   * @var string
   */
  private $details;

  /**
   * The difficulty of the exercise
   * @var string
   */
  private $difficulty;

  /**
   * The machine if needed
   * @var int
   */
  private $machine;



  /**
   * The constructor
   *
   * @param string $username The name of the user
   * @param string $password The password of the user
   */
  public function __construct($id=NULL, $name=NULL, $type=NULL, $details=NULL, $difficulty=NULL, $machine=NULL) {
    $this->id = $id;
    $this->name = $name;
    $this->type = $type;
    $this->details = $details;
    $this->difficulty = $difficulty;
    $this->machine = $machine;
  }

  /**
   * Gets the ID of this user
   *
   * @return string The ID of this user
   */
  public function getId() {
    return $this->id;
  }

  /**
  * Gets the Name of this exercise
  *
  * @return string The Name of this exercise
  */
  public function getName() {
    return $this->name;
  }

  /**
  * Sets the name of this exercise
  *
  * @param string $name The name of this exercise
  * @return void
  */
  public function setName($name) {
    $this->name = $name;
  }

  /**
   * Gets the Type of this exercise
   *
   * @return string The Type of this exercise
   */
  public function getType() {
    return $this->type;
  }

  /**
   * Sets the type of this exercise
   *
   * @param string $type The type of this exercise
   * @return void
   */
  public function setType($type) {
    $this->type = $type;
  }

  /**
   * Gets the details of this exercise
   *
   * @return string The details of this exercise
   */
  public function getDetails() {
    return $this->details;
  }
  /**
   * Sets the phone of this user
   *
   * @param int $phone The phone of this user
   * @return void
   */
  public function setDetails($details) {
    $this->details = $details;
  }

  /**
   * Gets the difficulty of this exercise
   *
   * @return string The difficulty of this exercise
   */
  public function getDifficulty() {
    return $this->difficulty;
  }
  /**
   * Sets the difficulty of this exercise
   *
   * @param string $difficulty The difficulty of this exercise
   * @return void
   */
  public function setDifficulty($difficulty) {
    $this->difficulty = $difficulty;
  }

  /**
   * Gets the machine if needed
   *
   * @return int The machine if needed
   */
  public function getMachine() {
    return $this->machine;
  }
  /**
   * Sets the machine if needed
   *
   * @param int $machine The difficulty of this exercise
   * @return void
   */
  public function setMachine($machine) {
    $this->machine = $machine;
  }

  /**
   * Checks if the current user instance is valid
   * for being registered in the database
   *
   * @throws ValidationException if the instance is
   * not valid
   *
   * @return void
   */
  public function checkIsValidForAdd() {
      $errors = array();
      if (strlen($this->name) < 5) {
	       $errors["name"] = "Name must be at least 5 characters length";
      }
      //TODO:Sacar de la base de datos
      if ( !in_Array($this->type, array("endurance", "strength", "flexibility")) ) {
         $errors["type"] = "That type doen't exist";
      }
      if ( strlen($this->details) < 10 ) {
         $errors["details"] = "Details must be at least 10 characters length";
      }
      //TODO:Sacar de la base de datos
      if ( !in_Array($this->difficulty, array("easy", "medium", "hard")) ) {
         $errors["difficulty"] = "That difficulty doen't exist";
      }
      if (sizeof($errors)>0){
	       throw new ValidationException($errors, "Exercise is not valid");
      }
  }

  public function checkIsValidForUpdate() {
    $errors = array();

    if (!isset($this->id)) {
      $errors["id"] = "ID is mandatory";
    }

    try{
      $this->checkIsValidForAdd();
    }catch(ValidationException $ex) {
      foreach ($ex->getErrors() as $key=>$error) {
	       $errors[$key] = $error;
      }
    }
    if (sizeof($errors) > 0) {
      throw new ValidationException($errors, "User is not valid");
    }
  }
}