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
class User {

  /**
   * The id of this user
   * @var string
   */
  private $id;

  /**
   * The type of the user
   * @var string
   */
  private $type;

  /**
   * The email of the user
   * @var string
   */
  private $email;
  /**
   * The name of the user
   * @var string
   */
  private $name;

  /**
   * The phone of the user
   * @var string
   */
  private $phone;
  /**
   * The password of the user
   * @var string
   */
  private $password;


  /**
   * The constructor
   *
   * @param string $username The name of the user
   * @param string $password The password of the user
   */
  public function __construct($id=NULL, $type=NULL, $email=NULL, $name=NULL, $phone=NULL, $password=NULL) {
    $this->id = $id;
    $this->type = $type;
    $this->email = $email;
    $this->name = $name;
    $this->phone = $phone;
    $this->password = $password;
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
   * Gets the Type of this user
   *
   * @return string The Type of this user
   */
  public function getType() {
    return $this->type;
  }

  /**
   * Sets the type of this user
   *
   * @param string $type The type of this user
   * @return void
   */
  public function setType($type) {
    $this->type = $type;
  }

  /**
   * Gets the email of this user
   *
   * @return string The email of this user
   */
  public function getEmail() {
    return $this->email;
  }

  /**
   * Sets the email of this user
   *
   * @param string $email The email of this user
   * @return void
   */
  public function setEmail($email) {
    $this->email = $email;
  }

  /**
   * Gets the Name of this user
   *
   * @return string The Name of this user
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Sets the username of this user
   *
   * @param string $name The name of this user
   * @return void
   */
  public function setName($name) {
    $this->name = $name;
  }

  /**
   * Gets the phone of this user
   *
   * @return string The phone of this user
   */
  public function getPhone() {
    return $this->phone;
  }
  /**
   * Sets the phone of this user
   *
   * @param int $phone The phone of this user
   * @return void
   */
  public function setPhone($phone) {
    $this->phone = $phone;
  }

  /**
   * Gets the password of this user
   *
   * @return string The password of this user
   */
  public function getPassword() {
    return $this->password;
  }
  /**
   * Sets the password of this user
   *
   * @param string $password The password of this user
   * @return void
   */
  public function setPassword($password) {
    $this->password = $password;
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
  public function checkIsValidForRegister() {
      $errors = array();
      if (strlen($this->name) < 5) {
	       $errors["name"] = "Name must be at least 5 characters length";
      }
      if (strlen($this->password) < 5) {
	       $errors["password"] = "Password must be at least 5 characters length";
      }
      if ( !filter_var( $this->email, FILTER_VALIDATE_EMAIL ) ) {
         $errors["email"] = "This is not a valid eMail address";
      }
      //TODO:Sacar de la base de datos
      if ( !in_Array($this->type, array("athlete", "coach", "admin")) ) {
         $errors["type"] = "That type doen't exist";
      }
      if (strlen($this->phone) < 9) {
         $errors["phone"] = "Phone must have 9 digits";
      }
      if (sizeof($errors)>0){
	       throw new ValidationException($errors, "User is not valid");
      }
  }

  public function checkIsValidForUpdate() {
    $errors = array();

    if (!isset($this->id)) {
      $errors["id"] = "ID is mandatory";
    }

    try{
      if (strlen($this->name) < 5) {
	       $errors["name"] = "Name must be at least 5 characters length";
      }
      if (strlen($this->password) != 0){
        if (strlen($this->password) < 5) {
  	       $errors["password"] = "Password must be at least 5 characters length";
        }
      }
      if ( !filter_var( $this->email, FILTER_VALIDATE_EMAIL ) ) {
         $errors["email"] = "This is not a valid eMail address";
      }
      //TODO:Sacar de la base de datos
      if ( !in_Array($this->type, array("athlete", "coach", "admin")) ) {
         $errors["type"] = "That type doen't exist";
      }
      if (strlen($this->phone) < 9) {
         $errors["phone"] = "Phone must have 9 digits";
      }
      if (sizeof($errors)>0){
	       throw new ValidationException($errors, "User is not valid");
      }
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