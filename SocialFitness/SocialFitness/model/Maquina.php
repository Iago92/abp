<?php
// file: model/Maquina.php

require_once(__DIR__."/../core/ValidationException.php");

/**
 * Class User
 *
 * Represents a User in the blog
 *
 * @author lipido <lipido@gmail.com>
 */
class Maquina {

  /**
   * The id of this user
   * @var string
   */
  private $id;

  /**
   * The phone of the user
   * @var string
   */
  private $ubicacion;
  /**
   * The name of the user
   * @var string
   */
  private $name;


  /**
   * The constructor
   *
   * @param string $username The name of the user
   * @param string $password The password of the user
   */
  public function __construct($id=NULL, $name=NULL, $ubicacion=NULL) {
    $this->id = $id;
    $this->name = $name;
    $this->ubicacion = $ubicacion;
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
  public function getName() {
    return $this->name;
  }

  /**
   * Sets the type of this user
   *
   * @param string $type The type of this user
   * @return void
   */
    public function getUbicacion() {
    return $this->ubicacion;
  }


  public function setUbicacion($ubicacion) {
    $this->ubicacion = $ubicacion;
  }
   public function setName($name) {
    $this->name = $name;
  }


  public function checkIsValidForAdd() {
      $errors = array();
      if (strlen($this->name) < 0) {
	       $errors["name"] = "Name must be at least 5 characters length";
      }

      if ( strlen($this->ubicacion) < 0 ) {
         $errors["ubicacion"] = "ubicacion must be at least 5 characters length";
      }

      if (sizeof($errors)>0){
	       throw new ValidationException($errors, "Maquinas is not valid");
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
