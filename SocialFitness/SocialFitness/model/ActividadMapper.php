<?php
// file: model/UserMapper.php
require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/../model/User.php");
/**
 * Class UserMapper
 *
 * Database interface for User entities
 *
 * @author lipido <lipido@gmail.com>
 */
class ActividadMapper {
  /**
   * Reference to the PDO connection
   * @var PDO
   */
  private $db;
  public function __construct() {
    $this->db = PDOConnection::getInstance();
  }
  /**
   * Saves a User into the database
   *TODO: this
   * @param User $user The user to be saved
   * @throws PDOException if a database error occurs
   * @return void
   */
  public function add($actividad) {
    $stmt = $this->db->prepare( "INSERT INTO actividad (id_actividad, nombre, horario, descripcion, num_plazas, entrenador) values (?,?,?,?,?,?)" );
   $stmt->execute(array($actividad->getID(), $actividad->getNombre(),$actividad->getHorario(), $actividad->getDescripcion(), $actividad->getNum_plazas(), $actividad->getEntrenador() ) );

  }
  /**
   * Deletes a User into the database
   *TODO:this
   * @param User $user The user to be deleted
   * @throws PDOException if a database error occurs
   * @return void
   */
  public function delete(Actividad $actividad) {
    $stmt = $this->db->prepare("DELETE from actividad WHERE id_actividad=?");
    $stmt->execute(array($actividad->getId()));
  }
  /**
   * Updates a User in the database
   *TODO:this
   * @param User $user The user to be updated
   * @throws PDOException if a database error occurs
   * @return void
   */
  public function update(Actividad $actividad) {
    $stmt = $this->db->prepare("UPDATE actividad SET nombre=?, horario=?, descripcion=?, num_plazas=?, entrenador=? WHERE id_actividad=?");
    $stmt->execute( array( $actividad->getNombre(),$actividad->getHorario(), $actividad->getDescripcion(), $actividad->getNum_plazas(), $actividad->getEntrenador(), $actividad->getId() ) );
  }
  /**
   * Loads a User from the database given its id
   * @throws PDOException if a database error occurs
   * @return User The User instances
   * NULL if the User is not found
   * TODO: this
   */
  public function findById($actividadid){
    $stmt = $this->db->prepare("SELECT * FROM actividad LEFT JOIN usuario ON id_usuario=entrenador WHERE id_actividad=?");
    $stmt->execute(array($actividadid));
    $actividad = $stmt->fetch(PDO::FETCH_ASSOC);

    if($actividad != null) {
      $entrenador = new User( $actividad['id_usuario'],NULL,NULL, $actividad['nombre_usuario'] );
      return new Actividad( $actividad["id_actividad"], $actividad["nombre"], $actividad["horario"], $actividad['descripcion'], $actividad["num_plazas"], $entrenador );
    } else {
      return NULL;
    }
  }

  /**
   * Retrieves all users
   * @throws PDOException if a database error occurs
   * @return mixed Array of Users instances
   */
  public function findAll() {
    $stmt = $this->db->query( "SELECT * FROM actividad LEFT JOIN usuario ON id_usuario=entrenador" );
    $actividades_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $actividades = array();

    foreach ($actividades_db as $actividad) {
        $entrenador = new User( $actividad['id_usuario'],NULL,NULL, $actividad['nombre_usuario'] );
      array_push( $actividades, new Actividad( $actividad["id_actividad"], $actividad["nombre"], $actividad["horario"], $actividad['descripcion'], $actividad["num_plazas"], $entrenador ) );
    }

    return $actividades;
  }
  /**
   * Checks if a given username is already in the database
   *TODO:here
   * @param string $username the username to check
   * @return boolean true if the username exists, false otherwise
   */
  public function nameExists($nombre) {
    $stmt = $this->db->prepare( "SELECT count(nombre) FROM actividad where nombre=?" );
    $stmt->execute(array($nombre));
    if ($stmt->fetchColumn() > 0) {
      return true;
    }
  }

  public function alreadyInscribed($activityid, $userid) {
    $stmt = $this->db->prepare( "SELECT count(id_usuario) FROM actividad_usuario WHERE id_usuario=? AND id_actividad=?" );
    $stmt->execute(array($userid,$activityid));
    $errors = array();
    if ($stmt->fetchColumn() > 0) {
      $errors["activity"] = "User already inscribed";
      throw new ValidationException($errors, "User already inscribed");
    }
  }

  public function checkCapacity($activityid) {
    $stmt = $this->db->prepare( "SELECT count(id_actividad) FROM actividad_usuario WHERE id_actividad=?" );
    $stmt->execute(array($activityid));
    $inscribed = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $this->db->prepare( "SELECT num_plazas FROM actividad WHERE id_actividad=?" );
    $stmt->execute(array($activityid));
    $capacity = $stmt->fetch(PDO::FETCH_ASSOC);

    $errors = array();
    if ($capacity["num_plazas"] <= $inscribed["count(id_actividad)"]) {
      $errors["activity"] = "This activity is full";
      throw new ValidationException($errors, "This activity is full");
    }
  }

  public function inscribe($activityid,$userid) {
    $stmt = $this->db->prepare( "INSERT INTO actividad_usuario (id_usuario, id_actividad) VALUES (?,?)" );
    $stmt->execute( array( $userid, $activityid ) );
  }

  public function usersByUserId($actividadid) {
    $stmt = $this->db->prepare("SELECT id_usuario FROM actividad_usuario WHERE id_actividad=?");
    $stmt->execute(array($actividadid));
    $users = $stmt->fetchAll(PDO::FETCH_COLUMN);

    return $users;
  }

  public function leave($activityid,$userid) {
    $stmt = $this->db->prepare("DELETE from actividad_usuario WHERE id_actividad=? AND id_usuario=?");
    $stmt->execute(array($activityid,$userid));
  }

}