<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/Maquina.php");
require_once(__DIR__."/../model/MaquinaMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
 * Class MaquinasController
 */
class MaquinasController extends BaseController {

  /**
   * Reference to the UserMapper to interact
   * with the database
   *
   * @var UserMapper
   */
  private $maquinaMapper;

  public function __construct() {
    parent::__construct();

    $this->maquinaMapper = new MaquinaMapper();

    // Users controller operates in a "welcome" layout
    // different to the "default" layout where the internal
    // menu is displayed
    //$this->view->setLayout("default");
  }

  /**
    * Action to list maquinas
    * @return void
    */
  public function index() {

    // obtain the data from the database
    $maquinas = $this->maquinaMapper->findAll();

    // put the array containing Post object to the view
    $this->view->setVariable("maquinas", $maquinas);

    // render the view (/view/posts/index.php)
    $this->view->render("maquinas", "index");
  }


 /**
   * Action add maquina
   * @return void
   */
  public function add() {
    //$this->checkPrivileges("admin");
    $maquina = new Maquina();

    if (isset($_POST["name"]) && isset($_POST["ubicacion"])){ // reaching via HTTP Post...

      // populate the User object with data form the form
      $maquina->setName($_POST["name"]);
      $maquina->setUbicacion($_POST["ubicacion"]);
      try{
      	$maquina->checkIsValidForAdd(); // if it fails, ValidationException

      	// check if user exists in the database
      	if (!$this->maquinaMapper->nameExists( $_POST["name"] ) ){

      	  // save the User object into the database
      	  $this->maquinaMapper->add($maquina);

      	  // POST-REDIRECT-GET
      	  // Everything OK, we will redirect the user to the list of posts
      	  // We want to see a message after redirection, so we establish
      	  // a "flash" message (which is simply a Session variable) to be
      	  // get in the view after redirection.
      	  $this->view->setFlash( sprintf( i18n("Machine \"%s\" successfully added"),$maquina->getName() ) );

      	  // perform the redirection. More or less:
      	  // header("Location: index.php?controller=users&action=login")
      	  // die();
      	  $this->view->redirect( "maquinas", "index" );
      	} else {
        	  $errors = array();
        	  $errors["name"] = "A machine with that name already exists";
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
    $this->view->setVariable("maquina", $maquina);

    // render the view (/view/users/register.php)
    $this->view->render("maquinas", "add");

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
    $maquinaid = $_GET["id"];
    $maquina = $this->maquinaMapper->findById($maquinaid);

    // TODO:Check if the User author is the currentUser (in Session)
    //if ($this->currentUser->getType() != "admin") {
    //  throw new Exception("The logged user is not an admin");
    //}

    // Does the user exist?
    if ($maquina == NULL) {
      throw new Exception("No such maquina with id: ".$maquinaid);
    }

    // Delete the User object from the database
    $this->maquinaMapper->delete($maquina);

    // POST-REDIRECT-GET
    // Everything OK, we will redirect the user to the list of posts
    // We want to see a message after redirection, so we establish
    // a "flash" message (which is simply a Session variable) to be
    // get in the view after redirection.
    $this->view->setFlash( sprintf( i18n("Machine \"%s\" successfully deleted"),$maquina->getName() ) );

    // perform the redirection. More or less:
    // header("Location: index.php?controller=posts&action=index")
    // die();
    $this->view->redirect("maquinas", "index");

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
      throw new Exception("A maquina id is mandatory");
    }

    if (!isset($this->currentUser)) {
      throw new Exception("Not in session. Managing actions requires login");
    }

    /*if (!isset($this->currentUser)) {
      throw new Exception("Not in session. Managing actions requires login");
    }*/

    // TODO:Check if the current user is admin
    //if ($post->getAuthor() != $this->currentUser) {
    //  throw new Exception("logged user is not the author of the post id ".$postid);
    //}

    // Get the User object from the database
    $maquinaid = $_GET["id"];
    $maquina = $this->maquinaMapper->findById($maquinaid);

    // Does the user exist?
    if ($maquina == NULL) {
      throw new Exception("No such maquina with id: ".$maquinaid);
    }

    if (isset($_POST["submit"])) { // reaching via HTTP Post...

      // populate the Post object with data form the form
      $maquina->setName($_POST["name"]);
      $maquina->setUbicacion($_POST["ubicacion"]);


      try {
        // validate Post object
        $maquina->checkIsValidForUpdate(); // if it fails, ValidationException

        // update the Post object in the database
        $this->maquinaMapper->update($maquina);

        // POST-REDIRECT-GET
        // Everything OK, we will redirect the user to the list of posts
        // We want to see a message after redirection, so we establish
        // a "flash" message (which is simply a Session variable) to be
        // get in the view after redirection.
        $this->view->setFlash( sprintf( i18n( "Machine \"%s\" successfully updated"),$maquina ->getName() ) );

        // perform the redirection. More or less:
        // header("Location: index.php?controller=posts&action=index")
        // die();
        $this->view->redirect("maquinas", "index");

      }catch(ValidationException $ex) {
        // Get the errors array inside the exepction...
        $errors = $ex->getErrors();
        // And put it to the view as "errors" variable
        $this->view->setVariable("errors", $errors);
      }
    }
    // Put the User object visible to the view
    $this->view->setVariable("maquina", $maquina);

    // render the view (/view/users/edit.php)
    $this->view->render("maquinas", "edit");
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

    $maquinaid = $_GET["id"];

    // find the Post object in the database
    $maquina = $this->maquinaMapper->findById($maquinaid);

    if ($maquina == NULL) {
      throw new Exception("No such mquina with id: ".$maquinaid);
    }

    // put the Post object to the view
    $this->view->setVariable("maquina", $maquina);

    // render the view (/view/posts/view.php)
    $this->view->render("maquinas", "view");

  }
}
