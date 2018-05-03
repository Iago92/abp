<?php
//file: controller/BaseController.php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/User.php");

/**
 * Class BaseController
 *
 * Implements a basic super constructor for
 * the controllers in the Blog App.
 * Basically, it provides some protected
 * attributes and view variables.
 *
 * @author lipido <lipido@gmail.com>
 */
class BaseController {

  /**
   * The view manager instance
   * @var ViewManager
   */
  protected $view;

  /**
   * The current user instance
   * @var User
   */
  protected $currentUser;

  public function __construct() {

    $this->view = ViewManager::getInstance();

    // get the current user and put it to the view
    if (session_status() == PHP_SESSION_NONE) {
	     session_start();
    }

    if(isset($_SESSION["currentuser"]) && isset($_SESSION["currenttype"]) && isset($_SESSION["currentid"])) {

      $this->currentUser = new User($_SESSION["currentid"],$_SESSION["currenttype"],null,$_SESSION["currentuser"],null,null);
      //add current user to the view, since some views require it
      $this->view->setVariable("currentusername",
				  $this->currentUser->getName());
      $this->view->setVariable("currentusertype",
				  $this->currentUser->getType());
      $this->view->setVariable("currentuserid",
				  $this->currentUser->getId());
    }
  }

  //Checks privileges for 1 or 2 types of user
  public function checkPrivileges($type1, $type2=null){
    if( isset( $_SESSION["currentuser"] ) ){
      if($type2!=null){
        if ($this->currentUser->getType()!=$type1 && $this->currentUser->getType()!=$type2){
          throw new Exception("You have no privileges to do that");
        }
      }
      else{
        if ($this->currentUser->getType()!=$type1){
          throw new Exception("You have no privileges to do that");
        }
      }
    }
  }
}
