<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/Exercise.php");
require_once(__DIR__."/../model/ExerciseMapper.php");
require_once(__DIR__."/../model/MaquinaMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
 * Class ExerciseController
 */
class ExercisesController extends BaseController {

  /**
   * Reference to the ExerciseMapper to interact
   * with the database
   *
   * @var ExerciseMapper
   */
  private $exerciseMapper;

  /**
   * Reference to the UserMapper to interact
   * with the database
   *
   * @var UserMapper
   */
  private $machineMapper;

  public function __construct() {
    parent::__construct();

    $this->exerciseMapper = new ExerciseMapper();
    $this->machineMapper = new MaquinaMapper();

    // Users controller operates in a "welcome" layout
    // different to the "default" layout where the internal
    // menu is displayed
    $this->view->setLayout("default");
  }

  /**
  * Action to list exercises
  * @return void
  */
  public function index() {

    // obtain the data from the database
    $exercises = $this->exerciseMapper->findAll();

    // put the array containing Post object to the view
    $this->view->setVariable("exercises", $exercises);

    // render the view (/view/posts/index.php)
    $this->view->render("exercises", "index");
  }

 /**
   * Action to add exercice
   * @return void
   */
  public function add() {
    $this->checkPrivileges("coach");
    $exercise = new Exercise();

    if ( isset($_POST["name"]) && isset($_POST["type"]) && isset($_POST["details"]) && isset($_POST["difficulty"]) ){ // reaching via HTTP Post...

      // populate the User object with data form the form
      $exercise->setName($_POST["name"]);
      $exercise->setType($_POST["type"]);
      $exercise->setDetails($_POST["details"]);
      $exercise->setDifficulty($_POST["difficulty"]);
      if( $_POST['machine'] != "" ){
        $machine = new Maquina($_POST["machine"]);
      }
      else {
        $machine = new Maquina();
      }
      $exercise->setMachine($machine);

      try{
      	$exercise->checkIsValidForAdd(); // if it fails, ValidationException

      	// check if user exists in the database
      	if (!$this->exerciseMapper->nameExists( $_POST["name"] ) ){

      	  // save the User object into the database
      	  $this->exerciseMapper->add($exercise);

      	  // POST-REDIRECT-GET
      	  // Everything OK, we will redirect the user to the list of posts
      	  // We want to see a message after redirection, so we establish
      	  // a "flash" message (which is simply a Session variable) to be
      	  // get in the view after redirection.
      	  $this->view->setFlash( "Exercise " . $exercise->getName() . " successfully added" );

      	  // perform the redirection. More or less:
      	  // header("Location: index.php?controller=users&action=login")
      	  // die();
      	  $this->view->redirect( "exercises", "index" );
      	} else {
        	  $errors = array();
        	  $errors["name"] = "An exercise with that name already exists";
        	  $this->view->setVariable("errors", $errors);
      	}
      }catch(ValidationException $ex) {
      	// Get the errors array inside the exepction...
      	$errors = $ex->getErrors();
      	// And put it to the view as "errors" variable
      	$this->view->setVariable("errors", $errors);
      }
    }

    $machines = $this->machineMapper->findAll();
    $this->view->setVariable("machines", $machines);

    // Put the User object visible to the view
    $this->view->setVariable("exercise", $exercise);

    // render the view (/view/users/register.php)
    $this->view->render("exercises", "add");

  }

  /**
   * Action to delete a user
   * @throws Exception if the current logged user is not an coach
   * @throws Exception if no id was provided
   * @throws Exception if no user is in session
   * @throws Exception if there is not any user with the provided id
   * @return void
   */
  public function delete() {
    $this->checkPrivileges("coach");
    if (!isset($_GET["id"])) {
      throw new Exception("ID is mandatory");
    }
    if (!isset($this->currentUser)) {
      throw new Exception("Not in session. Managing actions requires login");
    }

     // Get the User object from the database
    $exerciseid = $_GET["id"];
    $exercise = $this->exerciseMapper->findById($exerciseid);

    // TODO:Check if the User author is the currentUser (in Session)
    //if ($this->currentUser->getType() != "admin") {
    //  throw new Exception("The logged user is not an admin");
    //}

    // Does the user exist?
    if ($exercise == NULL) {
      throw new Exception("No such exercise with id: ".$exerciseid);
    }

    // Delete the User object from the database
    $this->exerciseMapper->delete($exercise);

    // POST-REDIRECT-GET
    // Everything OK, we will redirect the user to the list of posts
    // We want to see a message after redirection, so we establish
    // a "flash" message (which is simply a Session variable) to be
    // get in the view after redirection.
    $this->view->setFlash( sprintf( i18n("Exercise \"%s\" successfully deleted"),$exercise->getName() ) );

    // perform the redirection. More or less:
    // header("Location: index.php?controller=posts&action=index")
    // die();
    $this->view->redirect("exercises", "index");

  }

  /**
   * Action to edit a user
   *
   * @throws Exception if the current logged user is not a coach
   * @throws Exception if no id was provided
   * @throws Exception if no user is in session
   * @throws Exception if there is not any user with the provided id
   * @return void
   */

  public function edit() {
    $this->checkPrivileges("coach");
    if (!isset($_GET["id"])) {
      throw new Exception("A exercise id is mandatory");
    }

    if (!isset($this->currentUser)) {
      throw new Exception("Not in session. Managing actions requires login");
    }

    // TODO:Check if the current user is admin
    //if ($post->getAuthor() != $this->currentUser) {
    //  throw new Exception("logged user is not the author of the post id ".$postid);
    //}

    // Get the User object from the database
    $exerciseid = $_GET["id"];
    $exercise = $this->exerciseMapper->findById($exerciseid);

    // Does the user exist?
    if ($exercise == NULL) {
      throw new Exception("no such user with id: ".$exerciseid);
    }

    if (isset($_POST["submit"])) { // reaching via HTTP Post...

      // populate the Exercise object with data form the form
      $exercise->setName($_POST["name"]);
      $exercise->setType($_POST["type"]);
      $exercise->setDetails($_POST["details"]);
      $exercise->setDifficulty($_POST["difficulty"]);
      if( $_POST['machine'] != "" ){
        $machine = new Maquina($_POST["machine"]);
      }
      else {
        $machine = new Maquina();
      }
      $exercise->setMachine($machine);

      try {
        // validate Post object
        $exercise->checkIsValidForUpdate(); // if it fails, ValidationException

        // update the Post object in the database
        $this->exerciseMapper->update($exercise);

        // POST-REDIRECT-GET
        // Everything OK, we will redirect the user to the list of posts
        // We want to see a message after redirection, so we establish
        // a "flash" message (which is simply a Session variable) to be
        // get in the view after redirection.
        $this->view->setFlash( sprintf( i18n( "Exercise \"%s\" successfully updated"),$exercise->getName() ) );

        // perform the redirection. More or less:
        // header("Location: index.php?controller=posts&action=index")
        // die();
        $this->view->redirect("exercises", "index");

      }catch(ValidationException $ex) {
        // Get the errors array inside the exepction...
        $errors = $ex->getErrors();
        // And put it to the view as "errors" variable
        $this->view->setVariable("errors", $errors);
      }
    }

    $machines = $this->machineMapper->findAll();
    $this->view->setVariable("machines", $machines);

    // Put the User object visible to the view
    $this->view->setVariable("exercise", $exercise);

    // render the view (/view/users/edit.php)
    $this->view->render("exercises", "edit");
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

    $exerciseid = $_GET["id"];

    // find the Post object in the database
    $exercise = $this->exerciseMapper->findById($exerciseid);

    if ($exercise == NULL) {
      throw new Exception("No such exercise with id: ".$exerciseid);
    }

    // put the Post object to the view
    $this->view->setVariable("exercise", $exercise);

    // render the view (/view/posts/view.php)
    $this->view->render("exercises", "view");

  }
}