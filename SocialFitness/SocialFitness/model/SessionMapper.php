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
class SessionMapper {

  /**
   * Reference to the PDO connection
   * @var PDO
   */
  private $db;

  public function __construct(){
    $this->db = PDOConnection::getInstance();
  }

  /**
   * Saves a User into the database
   *
   * @param User $user The user to be saved
   * @throws PDOException if a database error occurs
   * @return void
   */
  public function add($session) {
    $stmt = $this->db->prepare( "INSERT INTO sesion (descripcion_sesion,fecha_sesion,hora_sesion,id_sesion,id_usuario,nombre_sesion) values (?,?,?,?,?,?)" );
    $stmt->execute(array( $session->getDescription(), $session->getDate(),$session->getTime(), $session->getId(),$session->getIdUser(), $session->getName()) );
  }

  /**
   * Deletes a User into the database
   *
   * @param User $user The user to be deleted
   * @throws PDOException if a database error occurs
   * @return void
   */
  public function delete(Session $session) {
    $stmt = $this->db->prepare("DELETE from sesion WHERE id_sesion=?");
    $stmt->execute(array($session->getId()));
  }

  /**
   * Updates a User in the database
   *
   * @param User $user The user to be updated
   * @throws PDOException if a database error occurs
   * @return void
   */
  public function update(Session $session) {
    $stmt = $this->db->prepare("UPDATE sesion set  nombre_sesion=?, descripcion_sesion=?, fecha_sesion=?, hora_sesion=? where id_sesion=?");
    $stmt->execute( array($session->getName(), $session->getDescription(), $session->getDate(),$session->getTime(),$session->getId()) );
  }

  /**
   * Loads a User from the database given its id
   * @throws PDOException if a database error occurs
   * @return User The User instances
   * NULL if the User is not found
   */
  public function findById($sesionid){
    $stmt = $this->db->prepare("SELECT * FROM sesion WHERE id_sesion=?");
    $stmt->execute(array($sesionid));
    $session = $stmt->fetch(PDO::FETCH_ASSOC);

    if($session != null) {
      return new Session( $session["nombre_sesion"],$session["id_sesion"], $session["descripcion_sesion"], $session["hora_sesion"],$session["fecha_sesion"]);
    } else {
      return NULL;
    }
  }

  public function findByIdUser($userid){
    $stmt = $this->db->prepare( "SELECT * FROM sesion WHERE id_usuario=?" );
    $stmt->execute(array($userid));
    $sessions_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $sessions = array();

    foreach ($sessions_db as $session) {
      array_push( $sessions, new Session( $session["nombre_sesion"], $session["id_sesion"], $session["descripcion_sesion"],$session["hora_sesion"],$session["fecha_sesion"]) );
    }

    return $sessions;
  }


  /**
   * Retrieves all users
   * @throws PDOException if a database error occurs
   * @return mixed Array of Users instances
   */
  public function findAll() {
    $stmt = $this->db->query( "SELECT * FROM sesion" );
    $sessions_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sessions = array();

    foreach ($sessions_db as $session) {
      array_push( $sessions, new Session( $session["nombre_sesion"], $session["id_sesion"], $session["descripcion_sesion"],$session["hora_sesion"],$session["fecha_sesion"]) );
    }

    return $sessions;
  }


  public function nameExists($name) {
    $stmt = $this->db->prepare( "SELECT count(nombre_sesion) FROM sesion where nombre_sesion=?" );
    $stmt->execute(array($name));

    if ($stmt->fetchColumn() > 0) {
      return true;
    }
  }

}
