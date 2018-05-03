<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/Session.php");
require_once(__DIR__."/../model/SessionMapper.php");
require_once(__DIR__."/../model/UserMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
 * Class MaquinasController
 */
class SessionsController extends BaseController {

  /**
   * Reference to the UserMapper to interact
   * with the database
   *
   * @var UserMapper
   */
  private $sessionMapper;
  private $userMapper;
  public function __construct() {
    parent::__construct();

    $this->sessionMapper = new SessionMapper();


    // Users controller operates in a "welcome" layout
    // different to the "default" layout where the internal
    // menu is displayed
    //$this->view->setLayout("default");
    $this->view->setLayout("default");
  }

  /**
    * Action to list maquinas
    * @return void
    */

  public function index() {
    $userid=$_GET["id"];
    //$sessions=$this->sessionMapper->findById($userid);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // obtain the data from the database
    $sessions = $this->sessionMapper->findByIdUser($userid);
    //var_dump($sessions);
    // put the array containing Post object to the view
    $this->view->setVariable("sessions", $sessions);

    // render the view (/view/posts/index.php)
    $this->view->render("sessions", "index");
  }


 /**
   * Action add maquina
   * @return void
   */
   //$name=NULL, $id=NULL, $description_session=NULL, User $id_user=NULL, $time=NULL, $date=NULL
  public function add() {
    //$this->checkPrivileges("admin");
    $session = new Session();
										//id_sesion,descripcion_sesion, fecha_sesion , nombre_sesion, hora_sesion
    if (isset($_POST["name"])&& isset($_POST["description_session"])&& isset($_POST["time"])&&isset($_GET["id"])&& isset($_POST["date"])){ // reaching via HTTP Post...

      // populate the User object with data form the form
      $session->setName($_POST["name"]);
      $session->setDescription($_POST["description_session"]);
	    $session->setTime($_POST["time"]);
      $session->setUser($_GET["id"]);
      $session->setDate($_POST["date"]);
      try{
      	$session->checkIsValidForAdd(); // if it fails, ValidationException

      	// check if user exists in the database
      	if (!$this->sessionMapper->nameExists( $_POST["name"] ) ){

      	  // save the User object into the database
      	  $this->sessionMapper->add($session);

      	  // POST-REDIRECT-GET
      	  // Everything OK, we will redirect the user to the list of posts
      	  // We want to see a message after redirection, so we establish
      	  // a "flash" message (which is simply a Session variable) to be
      	  // get in the view after redirection.
      	  $this->view->setFlash( "Session " . $session->getName() . " anhadida correctamente" );

      	  // perform the redirection. More or less:
      	  // header("Location: index.php?controller=users&action=login")
      	  // die();
      	  $this->view->redirect("sessions", "index&id=".$this->currentUser->getId());
      	} else {
        	  $errors = array();
        	  $errors["name"] = "An session with that name already exists";
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
    $this->view->setVariable("session", $session);


    // render the view (/view/users/register.php)
      $this->view->render("sessions", "add");


  }


  /**
   * Action to delete a user
   * @throws Exception if no id was provided
   * @throws Exception if no user is in session
   * @throws Exception if there is not any user with the provided id
   * @throws Exception if the current logged user is not an admin
   * @return void
   */
  public function delete() {
    //$this->checkPrivileges("admin");
    if (!isset($_GET["id"])) {
      throw new Exception("ID is mandatory");
    }
   /* if (!isset($this->currentUser)) {
      throw new Exception("Not in session. Managing actions requires login");
    }*/

     // Get the User object from the database
    $sessionid = $_GET["id"];
    $session = $this->sessionMapper->findById($sessionid);

    // TODO:Check if the User author is the currentUser (in Session)
    //if ($this->currentUser->getType() != "admin") {
    //  throw new Exception("The logged user is not an admin");
    //}

    // Does the user exist?
    if ($session == NULL) {
      throw new Exception("No such session with id: ".$sessionid);
    }

    // Delete the User object from the database
    $this->sessionMapper->delete($session);

    // POST-REDIRECT-GET
    // Everything OK, we will redirect the user to the list of posts
    // We want to see a message after redirection, so we establish
    // a "flash" message (which is simply a Session variable) to be
    // get in the view after redirection.
    $this->view->setFlash( sprintf( i18n("Session \"%s\" successfully deleted"),$session->getName() ) );

    // perform the redirection. More or less:
    // header("Location: index.php?controller=posts&action=index")
    // die();
    $this->view->redirect("sessions", "index&id=".$this->currentUser->getId());

  }

  /**
   * Action to edit a user
   *
   * @throws Exception if no id was provided
   * @throws Exception if no user is in session
   * @throws Exception if there is not any user with the provided id
   * @throws Exception if the current logged user is not an admin
   * @return void
   */

  public function edit() {
  //  $this->checkPrivileges("admin");
    if (!isset($_REQUEST["id"])) {
      throw new Exception("A session id is mandatory");
    }

    /*if (!isset($this->currentUser)) {
      throw new Exception("Not in session. Managing actions requires login");
    }*/

    // TODO:Check if the current user is admin
    //if ($post->getAuthor() != $this->currentUser) {
    //  throw new Exception("logged user is not the author of the post id ".$postid);
    //}

    // Get the User object from the database
    $sessionid = $_REQUEST["id"];
    $session = $this->sessionMapper->findById($sessionid);

    // Does the user exist?
    if ($session == NULL) {
      throw new Exception("no such session with id: ".$sessionid);
    }

    if (isset($_POST["submit"])) { // reaching via HTTP Post...

      // populate the Post object with data form the form
      $session->setName($_POST["name"]);
      $session->setDescription($_POST["description_session"]);
      $session->setTime($_POST["time"]);
      $session->setDate($_POST["date"]);

      try {
        // validate Post object
        $session->checkIsValidForUpdate(); // if it fails, ValidationException

        // update the Post object in the database
        $this->sessionMapper->update($session);

        // POST-REDIRECT-GET
        // Everything OK, we will redirect the user to the list of posts
        // We want to see a message after redirection, so we establish
        // a "flash" message (which is simply a Session variable) to be
        // get in the view after redirection.
        $this->view->setFlash( sprintf( i18n( "Session \"%s\" successfully updated"),$session ->getName() ) );

        // perform the redirection. More or less:
        // header("Location: index.php?controller=posts&action=index")
        // die();
        $this->view->redirect("sessions", "index&id=".$this->currentUser->getId());

      }catch(ValidationException $ex) {
        // Get the errors array inside the exepction...
        $errors = $ex->getErrors();
        // And put it to the view as "errors" variable
        $this->view->setVariable("errors", $errors);
      }
    }
    // Put the User object visible to the view
    $this->view->setVariable("session", $session);

    // render the view (/view/users/edit.php)
    $this->view->render("sessions", "edit");
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

    $sessionid = $_GET["id"];

    // find the Post object in the database
    $session = $this->sessionMapper->findById($sessionid);

    if ($session == NULL) {
      throw new Exception("No such session with id: ".$sessionid);
    }

    // put the Post object to the view
    $this->view->setVariable("session", $session);

    // render the view (/view/posts/view.php)
    $this->view->render("sessions", "view");

  }
}
