<?php
require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");
require_once(__DIR__."/../model/Tabla.php");
require_once(__DIR__."/../model/TablaMapper.php");
require_once(__DIR__."/../model/Exercise.php");
require_once(__DIR__."/../model/ExerciseMapper.php");
require_once(__DIR__."/../controller/BaseController.php");
/**
 * Class ExerciseController
 */
class TablasController extends BaseController {
  /**
   * Reference to the UserMapper to interact
   * with the database
   *
   * @var UserMapper
   */
  private $tablaMapper;
  public function __construct() {
    parent::__construct();
    $this->tablaMapper = new TablaMapper();
    $this->exerciseMapper = new ExerciseMapper();
    // Users controller operates in a "welcome" layout
    // different to the "default" layout where the internal
    // menu is displayed
    //$this->view->setLayout("default");
  }
  /**
  * Action to list exercises
  * @return void
  */
  public function index() {
    // obtain the data from the database
    $tabla = $this->tablaMapper->findAll();
    // put the array containing Post object to the view
    $this->view->setVariable("tabla", $tabla);
    // render the view (/view/posts/index.php)
    $this->view->render("tablas", "index");
  }
 /**
   * Action to add actividad
   * @return void
   */
  public function add() {
    $tabla = new Tabla();

    $selected = array();
    if ( isset($_POST["nombre"]) && isset($_POST["num_ejercicios"]) && isset($_POST["tipo"]) && isset($_POST["dificultad"]) && isset($_POST["exercises"]) ) {
     // reaching via HTTP Post...
      // populate the User object with data form the form
   //die($_POST['entrenador']);
      $tabla->setNombre($_POST["nombre"]);
      $tabla->setNum_ejercicios($_POST["num_ejercicios"]);
      $tabla->setTipo($_POST["tipo"]);
      $tabla->setDificultad($_POST["dificultad"]);
      if (isset($_POST['exercises'])){
        $selected = $_POST['exercises'];
      }

      try{

      	$tabla->checkIsValidForAdd(); // if it fails, ValidationException
        if (!$this->tablaMapper->nameExists( $_POST["nombre"] ) ){
           $tableid = $this->tablaMapper->add($tabla);
           $this->exerciseMapper->setExercises($selected,$tableid);
      	   $this->view->setFlash( "Tabla " . $tabla->getNombre() . " añadida correctamente" );

      	  $this->view->redirect( "tablas", "index" );
          } else {
            $errors = array();
            $errors["nombre"] = "Ya existe una tabla con ese nombre";
            $this->view->setVariable("errors", $errors);
          }
      }catch(ValidationException $ac) {
      	// Get the errors array inside the exepction...
      	$errors = $ac->getErrors();
      	// And put it to the view as "errors" variable
      	$this->view->setVariable("errors", $errors);
      }
    }
    // Put the User object visible to the view
    $this->view->setVariable("tabla", $tabla);

    // Put the Tables visible to the view
    $exercises = $this->exerciseMapper->findAll();
    $this->view->setVariable("exercises", $exercises);
    $this->view->setVariable("selected", $selected);

    // render the view (/view/users/register.php)
    $this->view->render("tablas", "add");
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
    if (!isset($_GET["id"])) {
      throw new Exception("ID is mandatory");
    }
    //if (!isset($this->currentUser)) {
      //throw new Exception("Not in session. Managing actions requires login");
    //}
     // Get the User object from the database
    $tablaid = $_GET["id"];
    $tabla = $this->tablaMapper->findById($tablaid);

    // TODO:Check if the User author is the currentUser (in Session)
    //if ($this->currentUser->getType() != "admin") {
    //  throw new Exception("The logged user is not an admin");
    //}
    // Does the user exist?
    if ($tabla == NULL) {
      throw new Exception("No hay tabla con ese id: ".$tablaid);
    }
    // Delete the User object from the database
    $this->tablaMapper->delete($tabla);
    // POST-REDIRECT-GET
    // Everything OK, we will redirect the user to the list of posts
    // We want to see a message after redirection, so we establish
    // a "flash" message (which is simply a Session variable) to be
    // get in the view after redirection.
    $this->view->setFlash( sprintf( i18n("Tabla \"%s\" borrada correctamente"),$tabla->getNombre() ) );
    // perform the redirection. More or less:
    // header("Location: index.php?controller=posts&action=index")
    // die();
    $this->view->redirect("tablas", "index");
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

     if (!isset($_REQUEST["id"])) {
      throw new Exception("A tabla id is mandatory");
    }

    if (!isset($this->currentUser)) {
      throw new Exception("Not in session. Managing actions requires login");
    }


    // Get the User object from the database
    $tablaid = $_REQUEST["id"];
    $tabla = $this->tablaMapper->findById($tablaid);

    // Does the user exist?
    if ($tabla == NULL) {
      throw new Exception("No such activity with id: ".$tablaid);
    }
    if (isset($_POST["submit"])) { // reaching via HTTP Post...
      // populate the Exercise object with data form the form
      $tabla->setNombre($_POST["nombre"]);
      $tabla->setNum_ejercicios($_POST["num_ejercicios"]);
      $tabla->setTipo($_POST["tipo"]);
      $tabla->setDificultad($_POST["dificultad"]);
      if (isset($_POST['exercises'])){
        $selected = $_POST['exercises'];
      }

      try {
        // validate Post object
        $tabla->checkIsValidForUpdate(); // if it fails, ValidationException
        // update the Post object in the database
        $this->tablaMapper->update($tabla);
        $this->exerciseMapper->updateExercises($selected,$tablaid);

        $this->view->setFlash( sprintf( i18n( "Tabla \"%s\" successfully updated"),$tabla->getNombre() ) );

        $this->view->redirect("tablas", "index");
      }catch(ValidationException $ex) {
        // Get the errors array inside the exepction...
        $errors = $ex->getErrors();
        // And put it to the view as "errors" variable
        $this->view->setVariable("errors", $errors);
      }
    }
    else {
      $selected = $this->exerciseMapper->exerciseByTableId($tablaid);
    }
    // Put the User object visible to the view
    $this->view->setVariable("tabla", $tabla);

    // Put the Tables visible to the view
    $exercises = $this->exerciseMapper->findAll();
    $this->view->setVariable("exercises", $exercises);
    $this->view->setVariable("selected", $selected);

    // render the view (/view/users/edit.php)
    $this->view->render("tablas", "edit");
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

    $tablaid = $_REQUEST["id"];


    // find the Post object in the database
    $tabla = $this->tablaMapper->findById($tablaid);

    if ($tabla == NULL) {
      throw new Exception("No such tabla with id: ".$tablaid);
    }
    // put the Post object to the view
    $this->view->setVariable("tabla", $tabla);

    // Put the Tables visible to the view
    $exercises = $this->exerciseMapper->findAll();
    $selected = $this->exerciseMapper->exerciseByTableId($tablaid);
    $this->view->setVariable("exercises", $exercises);
    $this->view->setVariable("selected", $selected);
    // render the view (/view/posts/view.php)
    $this->view->render("tablas", "view");
  }
}