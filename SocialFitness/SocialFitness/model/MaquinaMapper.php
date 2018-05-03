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
class MaquinaMapper {

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
   *
   * @param User $user The user to be saved
   * @throws PDOException if a database error occurs
   * @return void
   */
  public function add($maquina) {
    $stmt = $this->db->prepare( "INSERT INTO maquina (id_maquina, ubicacion, nombre_maquina) values (?,?,?)" );
    $stmt->execute(array( $maquina->getId(), $maquina->getUbicacion(), $maquina->getName()) );
  }

  /**
   * Deletes a User into the database
   *
   * @param User $user The user to be deleted
   * @throws PDOException if a database error occurs
   * @return void
   */
  public function delete(Maquina $maquina) {
    $stmt = $this->db->prepare("DELETE from maquina WHERE id_maquina=?");
    $stmt->execute(array($maquina->getId()));
  }

  /**
   * Updates a User in the database
   *
   * @param User $user The user to be updated
   * @throws PDOException if a database error occurs
   * @return void
   */
  public function update(Maquina $maquina) {
    $stmt = $this->db->prepare("UPDATE maquina set ubicacion=?, nombre_maquina=? where id_maquina=?");
    $stmt->execute( array(   $maquina->getUbicacion(), $maquina->getName(), $maquina->getId() ) );
  }

  /**
   * Loads a User from the database given its id
   * @throws PDOException if a database error occurs
   * @return User The User instances
   * NULL if the User is not found
   */
  public function findById($maquinaid){
    $stmt = $this->db->prepare("SELECT * FROM maquina WHERE id_maquina=?");
    $stmt->execute(array($maquinaid));
    $maquina = $stmt->fetch(PDO::FETCH_ASSOC);

    if($maquina != null) {
      return new Maquina( $maquina["id_maquina"], $maquina["nombre_maquina"], $maquina["ubicacion"]);
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
    $stmt = $this->db->query( "SELECT * FROM maquina" );
    $maquinas_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $maquinas = array();

    foreach ($maquinas_db as $maquina) {
      array_push( $maquinas, new Maquina( $maquina["id_maquina"], $maquina["nombre_maquina"], $maquina["ubicacion"]) );
    }

    return $maquinas;
  }


  public function nameExists($name) {
    $stmt = $this->db->prepare( "SELECT count(nombre_maquina) FROM maquina where nombre_maquina=?" );
    $stmt->execute(array($name));

    if ($stmt->fetchColumn() > 0) {
      return true;
    }
  }

  /**
   * Checks if a given username is already in the database
   *
   * @param string $username the username to check
   * @return boolean true if the username exists, false otherwise
   */
  /*
  public function isValidUser($nombre_maquina, $ubicacion) {
    $stmt = $this->db->prepare("SELECT * FROM maquina where nombre_maquina=? and ubicacion=? GROUP BY id_maquina");
    $stmt->execute(array($nombre_maquina, $ubicacion));
    $maquinas_db = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($users_db > 0) {
      return new User( $users_db["id_usuario"], $users_db["tipo"], $users_db["email"], $users_db["nombre_usuario"], $users_db["telefono"], null );
    } else  {
      return NULL;
    }
  }*/
}
