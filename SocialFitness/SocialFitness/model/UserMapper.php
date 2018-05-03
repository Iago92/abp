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
class UserMapper {

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
  public function add($user) {
    $stmt = $this->db->prepare( "INSERT INTO usuario (tipo, email, nombre_usuario, telefono, contrasena) VALUES (?,?,?,?,?)" );
    $stmt->execute(array( $user->getType(), $user->getEmail(), $user->getName(), $user->getPhone(), MD5($user->getPassword()) ) );

    return $this->db->lastInsertId();
  }

  public function setTables ($tables, $userId) {
    foreach($tables as $value) {
      $stmt = $this->db->prepare( "INSERT INTO tabla_ejercicios_usuario (id_tabla_ejercicios, id_usuario) VALUES (?,?)" );
      $stmt->execute(array( $value, $userId ) );
    }
  }

  public function updateTables ($tables, $userid) {
    $this->db->exec( 'DELETE FROM tabla_ejercicios_usuario WHERE id_usuario='.$userid );
    foreach($tables as $value) {
      $stmt = $this->db->prepare( "INSERT INTO tabla_ejercicios_usuario (id_tabla_ejercicios, id_usuario) VALUES (?,?)" );
      $stmt->execute(array( $value, $userid ) );
    }
  }

  public function tablesByUserId($userid){
    $stmt = $this->db->prepare("SELECT id_tabla_ejercicios FROM tabla_ejercicios_usuario WHERE id_usuario=?");
    $stmt->execute(array($userid));
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    return $tables;
  }

  /**
   * Deletes a User into the database
   *
   * @param User $user The user to be deleted
   * @throws PDOException if a database error occurs
   * @return void
   */
  public function delete(User $user) {
    $stmt = $this->db->prepare("DELETE from usuario WHERE id_usuario=?");
    $stmt->execute(array($user->getId()));
  }

  /**
   * Updates a User in the database
   *
   * @param User $user The user to be updated
   * @throws PDOException if a database error occurs
   * @return void
   */
  public function update(User $user) {
    if( strlen($user->getPassword()) != 0 ){
      $stmt = $this->db->prepare("UPDATE usuario SET tipo=?, email=?, nombre_usuario=?, telefono=?, contrasena=? WHERE id_usuario=?");
      $stmt->execute( array( $user->getType(), $user->getEmail(), $user->getName(), $user->getPhone(), MD5($user->getPassword()), $user->getId() ) );
    }
    else {
      $stmt = $this->db->prepare("UPDATE usuario SET tipo=?, email=?, nombre_usuario=?, telefono=? WHERE id_usuario=?");
      $stmt->execute( array( $user->getType(), $user->getEmail(), $user->getName(), $user->getPhone(), $user->getId() ) );
    }
  }

  /**
   * Updates a User in the database
   *
   * @param User $user The user to be updated
   * @throws PDOException if a database error occurs
   * @return void
   */
  public function selfupdate(User $user) {
    if( strlen($user->getPassword()) != 0 ){
      $stmt = $this->db->prepare("UPDATE usuario SET email=?, nombre_usuario=?, telefono=?, contrasena=? WHERE id_usuario=?");
      $stmt->execute( array( $user->getEmail(), $user->getName(), $user->getPhone(), MD5($user->getPassword()), $user->getId() ) );
    }
    else {
      $stmt = $this->db->prepare("UPDATE usuario SET email=?, nombre_usuario=?, telefono=? WHERE id_usuario=?");
      $stmt->execute( array( $user->getEmail(), $user->getName(), $user->getPhone(), $user->getId() ) );
    }
  }

  /**
   * Loads a User from the database given its id
   * @throws PDOException if a database error occurs
   * @return User The User instances
   * NULL if the User is not found
   */
  public function findById($userid){
    $stmt = $this->db->prepare("SELECT * FROM usuario WHERE id_usuario=?");
    $stmt->execute(array($userid));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user != null) {
      return new User( $user["id_usuario"], $user["tipo"], $user['email'], $user["nombre_usuario"], $user["telefono"], $user["contrasena"] );
    } else {
      return NULL;
    }
  }

  /**
   * Loads a User from the database given its id
   * @throws PDOException if a database error occurs
   * @return User The User instances
   * NULL if the User is not found
   */
  public function findCoaches(){
    $stmt = $this->db->query( "SELECT * FROM usuario WHERE tipo='coach'" );
    $users_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $users = array();

    foreach ($users_db as $user) {
      array_push( $users, new User( $user["id_usuario"], $user["tipo"], $user["email"], $user["nombre_usuario"] ) );
    }

    return $users;
  }


  /**
   * Retrieves all users
   * @throws PDOException if a database error occurs
   * @return mixed Array of Users instances
   */
  public function findAll() {
    $stmt = $this->db->query( "SELECT * FROM usuario" );
    $users_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $users = array();

    foreach ($users_db as $user) {
      array_push( $users, new User( $user["id_usuario"], $user["tipo"], $user["email"], $user["nombre_usuario"], $user["telefono"], $user["contrasena"] ) );
    }

    return $users;
  }

  /**
   * Checks if a given username is already in the database
   *TODO:here
   *
   * @param string $username the username to check
   * @return boolean true if the username exists, false otherwise
   */
  public function emailExists($email) {
    $stmt = $this->db->prepare( "SELECT count(email) FROM usuario where email=?" );
    $stmt->execute(array($email));

    if ($stmt->fetchColumn() > 0) {
      return true;
    }
  }

  /**
   * Checks if a given pair of username/password exists in the database
   *
   * @param string email the email
   * @param string $password the password
   * @return User user with the name according to the logging
   */
  public function isValidUser($email, $password) {
    $stmt = $this->db->prepare("SELECT * FROM usuario where email=? and contrasena=? GROUP BY id_usuario");
    $stmt->execute(array($email, MD5($password)));
    $users_db = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($users_db > 0) {
      return new User( $users_db["id_usuario"], $users_db["tipo"], $users_db["email"], $users_db["nombre_usuario"], $users_db["telefono"], null );
    } else  {
      return NULL;
    }
  }
}