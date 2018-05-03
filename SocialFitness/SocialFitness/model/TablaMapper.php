<?php
// file: model/UserMapper.php
require_once(__DIR__."/../core/PDOConnection.php");
/**
 * Class UserMapper
 *
 * Database interface for User entities
 *
 * @author lipido <lipido@gmail.com>
 */
class TablaMapper {
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
  public function add($tabla) {
    $stmt = $this->db->prepare( "INSERT INTO tabla_ejercicios (id_tabla_ejercicios, nombre, num_ejercicios, tipo, dificultad) values (?,?,?,?,?)" );

   $stmt->execute(array($tabla->getID(), $tabla->getNombre(),$tabla->getNum_ejercicios(), $tabla->getTipo(), $tabla->getDificultad() ) );

   return $this->db->lastInsertId();
  }
  /**
   * Deletes a User into the database
   *TODO:this
   * @param User $user The user to be deleted
   * @throws PDOException if a database error occurs
   * @return void
   */
  public function delete(Tabla $tabla) {
    $stmt = $this->db->prepare("DELETE from tabla_ejercicios WHERE id_tabla_ejercicios=?");
    $stmt->execute(array($tabla->getId()));
  }
  /**
   * Updates a User in the database
   *TODO:this
   * @param User $user The user to be updated
   * @throws PDOException if a database error occurs
   * @return void
   */
  public function update(Tabla $tabla) {
    $stmt = $this->db->prepare("UPDATE tabla_ejercicios SET nombre=?, num_ejercicios=?, tipo=?, dificultad=? WHERE id_tabla_ejercicios=?");
    $stmt->execute( array( $tabla->getNombre(),$tabla->getNum_ejercicios(), $tabla->getTipo(), $tabla->getDificultad(), $tabla->getId() ) );
  }
  /**
   * Loads a User from the database given its id
   * @throws PDOException if a database error occurs
   * @return User The User instances
   * NULL if the User is not found
   * TODO: this
   */
  public function findById($tablaid){
    $stmt = $this->db->prepare("SELECT * FROM tabla_ejercicios WHERE id_tabla_ejercicios=?");
    $stmt->execute(array($tablaid));
    $tabla = $stmt->fetch(PDO::FETCH_ASSOC);


    if($tabla != null) {
      return new Tabla( $tabla["id_tabla_ejercicios"],
       $tabla["nombre"],
       $tabla["num_ejercicios"],
       $tabla['tipo'],
       $tabla["dificultad"]);

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
    $stmt = $this->db->query( "SELECT * FROM tabla_ejercicios" );
    $tabla_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $tablas = array();

    foreach ($tabla_db as $tabla) {
      array_push( $tablas, new Tabla(
        $tabla["id_tabla_ejercicios"], $tabla["nombre"],
        $tabla["num_ejercicios"],
        $tabla["tipo"],
        $tabla["dificultad"]));

    }
    return $tablas;
  }
  /**
   * Checks if a given username is already in the database
   *TODO:here
   * @param string $username the username to check
   * @return boolean true if the username exists, false otherwise
   */
  public function nameExists($nombre) {
    $stmt = $this->db->prepare( "SELECT count(nombre) FROM tabla_ejercicios where nombre=?" );
    $stmt->execute(array($nombre));
    if ($stmt->fetchColumn() > 0) {
      return true;
    }
  }

}