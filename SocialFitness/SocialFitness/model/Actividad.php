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
class Actividad {
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

  private $horario;
  /**
   * The type of the user
   * @var string
   */
  private $descripcion;
  /**
   * The email of the user
   * @var string
   */
  private $num_plazas;
  /**
   * The difficulty of the activity
   * @var string
   */
  private $entrenador;


  /**
   * The constructor
   *
   * @param string $username The name of the user
   * @param string $password The password of the user
   */
  public function __construct($id=NULL, $nombre=NULL, $horario=NULL, $descripcion=NULL, $num_plazas=NULL,  $entrenador=NULL) {
    $this->id = $id;
    $this->nombre = $nombre;
    $this->horario = $horario;
    $this->descripcion = $descripcion;
    $this->num_plazas = $num_plazas;
    $this->entrenador = $entrenador;

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
  public function getHorario() {
    return $this->horario;
  }
  /**
  * Sets the name of this activity
  *
  * @param string $name The name of this activity
  * @return void
  */
  public function setHorario($horario) {
    $this->horario = $horario;
  }
  /**
   * Gets the Type of this activity
   *
   * @return string The Type of this activity
   */
  public function getDescripcion() {
    return $this->descripcion;
  }
  /**
   * Sets the type of this activity
   *
   * @param string $type The type of this activity
   * @return void
   */
  public function setDescripcion($descripcion) {
    $this->descripcion = $descripcion;
  }
  /**
   * Gets the details of this activity
   *
   * @return string The details of this activity
   */
  public function getNum_plazas() {
    return $this->num_plazas;
  }
  /**
   * Sets the phone of this user
   *
   * @param int $phone The phone of this user
   * @return void
   */
  public function setNum_plazas($num_plazas) {
    $this->num_plazas = $num_plazas;
  }
  /**
   * Gets the difficulty of this activity
   *
   * @return string The difficulty of this activity
   */
  public function getEntrenador() {
    return $this->entrenador;
  }
  /**
   * Sets the difficulty of this activity
   *
   * @param string $difficulty The difficulty of this activity
   * @return void
   */
  public function setEntrenador($entrenador) {
    $this->entrenador = $entrenador;
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
      if (strlen($this->nombre) < 2) {
         $errors["nombre"] = "El nombre tiene que tener al menos 2 caracteres";
      }
      if (strlen($this->horario) < 3) {
	       $errors["horario"] = "El horario tiene que tener al menos 3 caracteres";
      }
      //TODO:Sacar de la base de datos

      if (strlen($this->descripcion) < 3 ) {
         $errors["descripcion"] = "La descripcion debe tener  al menos 3 caracteres";
      }
       if ( strlen($this->num_plazas) < 1 ) {
         $errors["num_plazas"] = "Tiene que haber al menos una plaza";
      }
      if ( strlen($this->entrenador) < 1 ) {
        $errors["coach"] = "Tiene que haber al menos un entrenador";
      }

      if (sizeof($errors)>0){
	       throw new ValidationException($errors, "Actividad no valida");
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
      throw new ValidationException($errors, "Actividad no valida");
    }
  }
}