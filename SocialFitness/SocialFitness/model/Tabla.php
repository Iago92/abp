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
class Tabla {
  /**
   * The id of this user
   * @var string
   */
  private $id;
  /**
   * The name of the user
   * @var string
   */
  private $nombre;

  private $num_ejercicios;
  /**
   * The type of the user
   * @var string
   */
  private $tipo;
  /**
   * The email of the user
   * @var string
   */
  private $dificultad;
  /**
   * The difficulty of the activity
   * @var string
   */


 
  /**
   * The constructor
   *
   * @param string $username The name of the user
   * @param string $password The password of the user
   */
  public function __construct($id=NULL, $nombre=NULL, $num_ejercicios=NULL, $tipo=NULL, $dificultad=NULL) {
    $this->id = $id;
    $this->nombre = $nombre;
    $this->num_ejercicios = $num_ejercicios;
    $this->tipo = $tipo;
    $this->dificultad = $dificultad;
   
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
  * Gets the Name of this activity
  *
  * @return string The Name of this activity
  */

  public function getNombre() {
    return $this->nombre;
  }
  /**
  * Sets the name of this activity
  *
  * @param string $name The name of this activity
  * @return void
  */
  public function setNombre($nombre) {
    $this->nombre = $nombre;
  }
  public function getNum_ejercicios() {
    return $this->num_ejercicios;
  }
  /**
  * Sets the name of this activity
  *
  * @param string $name The name of this activity
  * @return void
  */
  public function setNum_ejercicios($num_ejercicios) {
    $this->num_ejercicios = $num_ejercicios;
  }
  /**
   * Gets the Type of this activity
   *
   * @return string The Type of this activity
   */
  public function getTipo() {
    return $this->tipo;
  }
  /**
   * Sets the type of this activity
   *
   * @param string $type The type of this activity
   * @return void
   */
  public function setTipo($tipo) {
    $this->tipo = $tipo;
  }
  /**
   * Gets the details of this activity
   *
   * @return string The details of this activity
   */
  public function getDificultad() {
    return $this->dificultad;
  }
  /**
   * Sets the phone of this user
   *
   * @param int $phone The phone of this user
   * @return void
   */
  public function setDificultad($dificultad) {
    $this->dificultad = $dificultad;
  }
  /**
   * Gets the difficulty of this activity
   *
   * @return string The difficulty of this activity
   */
  
 
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
      if (strlen($this->nombre) < 1) {
         $errors["nombre"] = "El nombre tiene que tener al menos 2 caracteres";
      }
      if (strlen($this->num_ejercicios) < 1) {
	       $errors["num_ejercicios"] = "El num ejercicios tiene que tener al menos 1 caracteres";
      }
      //TODO:Sacar de la base de datos
     
      if (strlen($this->tipo) < 1 ) {
         $errors["tipo"] = "el tipo debe tener  al menos 3 caracteres";
      }
       if ( strlen($this->dificultad) < 1 ) {
         $errors["dificultad"] = "Tiene que haber al menos una dificultad";
      }
  
      if (sizeof($errors)>0){
	       throw new ValidationException($errors, "tabla no valida");
      }
  }
 public function checkIsValidForUpdate() {
    $errors = array();
    if (!isset($this->id)) {
      $errors["ID"] = "ID obligatorio";
    }
    try{
      $this->checkIsValidForAdd();
    }catch(ValidationException $ex) {
      foreach ($ex->getErrors() as $key=>$error) {
         $errors[$key] = $error;
      }
    }
    if (sizeof($errors) > 0) {
      throw new ValidationException($errors, "Tabla no valida");
    }
  }
}