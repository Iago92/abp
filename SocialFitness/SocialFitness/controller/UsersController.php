<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/UserMapper.php");
require_once(__DIR__."/../model/Tabla.php");
require_once(__DIR__."/../model/TablaMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
 * Class UsersController
 *
 * Controller to login, logout and user registration
 *
 * @author lipido <lipido@gmail.com>
 */
class UsersController extends BaseController {

  /**
   * Reference to the UserMapper to interact
   * with the database
   *
   * @var UserMapper
   */
  private $userMapper;

  /**
   * Reference to the TableMapper to interact
   * with the database
   *
   * @var TableMapper
   */
  private $tableMapper;

  public function __construct() {
    parent::__construct();

    $this->userMapper = new UserMapper();
    $this->tableMapper = new TablaMapper();

    // Users controller operates in a "welcome" layout
    // different to the "default" layout where the internal
    // menu is displayed
    $this->view->setLayout("default");
  }

 /**
   * Action to login
   * @return void
   */
  public function login() {
    $this->view->setLayout('welcome');
    if ( isset( $_POST["email"] ) && isset( $_POST["password"] ) ){ // reaching via HTTP Post...
      //process login form
      $username = $this->userMapper->isValidUser( $_POST["email"], $_POST["password"]);
      if ( $username != NULL ) {

        $_SESSION["currentid"]=$username->getId();
        $_SESSION["currentuser"]=$username->getName();
      	$_SESSION["currenttype"]=$username->getType();

      	// send user to the restricted area (HTTP 302 code)
      	$this->view->redirect("users", "index");

      }else{
      	$errors = array();
      	$errors["general"] = "Username or password is not valid";
      	$this->view->setVariable("errors", $errors);
      }
    }

    // render the view (/view/users/login.php)
    $this->view->render("users", "login");
  }

  /**
    * Action to list users
    * @return void
    */
  public function index() {

    // obtain the data from the database
    $users = $this->userMapper->findAll();

    // put the array containing Post object to the view
    $this->view->setVariable("users", $users);

    // render the view (/view/posts/index.php)
    $this->view->render("users", "index");
  }


 /**
   * Action to register
   * @return void
   */
  public function add() {
    $this->checkPrivileges("admin");
    $user = new User();
    $selected = array();
    if (isset($_POST["name"]) && isset($_POST["password"]) && isset($_POST["email"]) && isset($_POST["type"]) && isset($_POST["phone"])){ // reaching via HTTP Post...

      // populate the User object with data form the form
      $user->setName($_POST["name"]);
      $user->setPassword($_POST["password"]);
      $user->setEmail($_POST["email"]);
      $user->setType($_POST["type"]);
      $user->setPhone($_POST["phone"]);
      if (isset($_POST['tables'])){
        $selected = $_POST['tables'];
      }

      try{
      	$user->checkIsValidForRegister(); // if it fails, ValidationException

      	// check if user exists in the database
      	if (!$this->userMapper->emailExists( $_POST["email"] ) ){

      	  // save the User object into the database
      	  $userId=$this->userMapper->add($user);
          $this->userMapper->setTables($selected,$userId);
      	  $this->view->setFlash( "User " . $user->getName() . " successfully added. Please login now" );

      	  $this->view->redirect( "users", "index" );
      	} else {
        	  $errors = array();
        	  $errors["email"] = "Email already exists";
        	  $this->view->setVariable("errors", $errors);
      	}
      }catch(ValidationException $ex) {
      	// Get the errors array inside the exepction...
      	$errors = $ex->getErrors();

      	// And put it to the view as "errors" variable
      	$this->view->setVariable("errors", $errors);
      }
    }

    // Put the User object visible to the view
    $this->view->setVariable("user", $user);

    // Put the Tables visible to the view
    $tables = $this->tableMapper->findAll();
    $this->view->setVariable("tables", $tables);
    $this->view->setVariable("selected", $selected);

    // render the view (/view/users/register.php)
    $this->view->render("users", "add");

  }

  /**
   * Action to delete a user
   * @throws Exception if the current logged user is not an admin
   * @throws Exception if no id was provided
   * @throws Exception if no user is in session
   * @throws Exception if there is not any user with the provided id
   * @return void
   */
  public function delete() {
    $this->checkPrivileges("admin");

    if (!isset($_GET["id"])) {
      throw new Exception("ID is mandatory");
    }
    if (!isset($this->currentUser)) {
      throw new Exception("Not in session. Managing actions requires login");
    }

     // Get the User object from the database
    $userid = $_GET["id"];
    $user = $this->userMapper->findById($userid);

    // Does the user exist?
    if ($user == NULL) {
      throw new Exception("No such user with id: ".$userid);
    }

    // Delete the User object from the database
    $this->userMapper->delete($user);

    $this->view->setFlash( sprintf( i18n("User \"%s\" successfully deleted"),$user->getName() ) );

    $this->view->redirect("users", "index");

  }

  /**
   * Action to edit a user
   *
   * @throws Exception if the current logged user is not an admin
   * @throws Exception if no id was provided
   * @throws Exception if no user is in session
   * @throws Exception if there is not any user with the provided id
   * @return void
   */

  public function edit() {
    $this->checkPrivileges("admin");

    $selected = array();

    if (!isset($_GET["id"])) {
      throw new Exception("A user id is mandatory");
    }

    if (!isset($this->currentUser)) {
      throw new Exception("Not in session. Managing actions requires login");
    }

    // Get the User object from the database
    $userid = $_GET["id"];
    $user = $this->userMapper->findById($userid);

    // Does the user exist?
    if ($user == NULL) {
      throw new Exception("no such user with id: ".$userid);
    }

    if (isset($_POST["submit"])) { // reaching via HTTP Post...

      // populate the Post object with data form the form
      $user->setName($_POST["name"]);
      $user->setPassword($_POST["password"]);
      $user->setEmail($_POST["email"]);
      $user->setType($_POST["type"]);
      $user->setPhone($_POST["phone"]);
      if (isset($_POST['tables'])){
        $selected = $_POST['tables'];
      }

      try {
        // validate Post object
        $user->checkIsValidForUpdate(); // if it fails, ValidationException

        // update the Post object in the database
        $this->userMapper->update($user);
        $this->userMapper->updateTables($selected,$userid);

        $this->view->setFlash( sprintf( i18n( "User \"%s\" successfully updated"),$user ->getName() ) );

        $this->view->redirect("users", "index");

      }catch(ValidationException $ex) {
        // Get the errors array inside the exepction...
        $errors = $ex->getErrors();
        // And put it to the view as "errors" variable
        $this->view->setVariable("errors", $errors);
      }
    }
    else {
      $selected = $this->userMapper->tablesByUserId($userid);
    }
    // Put the User object visible to the view
    $this->view->setVariable("user", $user);

    // Put the Tables visible to the view
    $tables = $this->tableMapper->findAll();
    $this->view->setVariable("tables", $tables);
    $this->view->setVariable("selected", $selected);

    // render the view (/view/users/edit.php)
    $this->view->render("users", "edit");
  }

  public function selfedit() {
    $selected = array();

    if (!isset($_GET["id"])) {
      throw new Exception("A user id is mandatory");
    }

    if (!isset($this->currentUser)) {
      throw new Exception("Not in session. Managing actions requires login");
    }

    if ($_GET["id"] != $this->currentUser->getId() &&
        $this->currentUser->getType() != 'coach'
    ) {
      throw new Exception("You can't modify this profile");
    }

    // Get the User object from the database
    $userid = $_GET["id"];
    $user = $this->userMapper->findById($userid);

    // Does the user exist?
    if ($user == NULL) {
      throw new Exception("no such user with id: ".$userid);
    }

    if (isset($_POST["submit"])) { // reaching via HTTP Post...

      // populate the Post object with data form the form
      $user->setName($_POST["name"]);
      $user->setPassword($_POST["password"]);
      $user->setEmail($_POST["email"]);
      $user->setPhone($_POST["phone"]);
      if (isset($_POST['tables'])){
        $selected = $_POST['tables'];
      }

      try {
        // validate Post object
        $user->checkIsValidForUpdate(); // if it fails, ValidationException

        // update the Post object in the database
        $this->userMapper->selfupdate($user);
        $this->userMapper->updateTables($selected,$userid);

        $this->view->setFlash( sprintf( i18n( "User \"%s\" successfully updated"),$user ->getName() ) );

        $this->view->redirect("users", "view&id=".$userid);

      }catch(ValidationException $ex) {
        // Get the errors array inside the exepction...
        $errors = $ex->getErrors();
        // And put it to the view as "errors" variable
        $this->view->setVariable("errors", $errors);
      }
    }
    else {
      $selected = $this->userMapper->tablesByUserId($userid);
    }
    // Put the User object visible to the view
    $this->view->setVariable("user", $user);

    // Put the Tables visible to the view
    $tables = $this->tableMapper->findAll();
    $this->view->setVariable("tables", $tables);
    $this->view->setVariable("selected", $selected);

    // render the view (/view/users/edit.php)
    $this->view->render("users", "selfedit");
  }


  /**
   * Action to view a given user
   * @throws Exception If no such user of the given id is found
   * @return void
   *
   */
  public function view(){
    if (!isset($_GET["id"])) {
      throw new Exception("ID is mandatory");
    }

    $userid = $_GET["id"];

    // find the Post object in the database
    $user = $this->userMapper->findById($userid);

    if ($user == NULL) {
      throw new Exception("No such user with id: ".$userid);
    }

    // put the Post object to the view
    $this->view->setVariable("user", $user);
    // Put the Tables visible to the view
    $tables = $this->tableMapper->findAll();
    $selected = $this->userMapper->tablesByUserId($userid);
    $this->view->setVariable("tables", $tables);
    $this->view->setVariable("selected", $selected);

    // render the view (/view/posts/view.php)
    $this->view->render("users", "view");

  }

 /**
   * Action to logout
   * @return void
   */
  public function logout() {
    session_destroy();

    // perform a redirection. More or less:
    // header("Location: index.php?controller=users&action=login")
    // die();
    $this->view->redirect("users", "login");

  }

}