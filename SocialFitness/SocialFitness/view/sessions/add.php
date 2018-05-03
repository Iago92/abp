<?php
 //file: view/maquinas/register.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $errors = $view->getVariable("errors");
 $maquina = $view->getVariable("Session");
 $view->setVariable("title", "Add session");

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $currentuser = $view->getVariable("currentusername");
 $currentuserid = $view->getVariable("currentuserid");
 if (!isset($currentuser)){
   $view->redirect("users", "login");
 }
?>
  <div class="col-md-12 button-buffer">
    <h1><?= i18n("Add session")?></h1>
    <form action="index.php?controller=sessions&amp;action=add&amp;id=<?= $currentuserid ?>" method="POST">
      <div class="form-group">
          <label><?= i18n("Full name")?>:</label>
           <input type="text" class="form-control" name="name" value="">
           <div class="help-block">
          <?= isset($errors["name"])?$errors["name"]:"" ?><br>
        </div>
      </div>

    <div class="form-group">
    	  <label><?= i18n("Description session")?>:</label>
         <input type="text" class="form-control" name="description_session" value="">
         <div class="help-block">
          <?= isset($errors["description_session"])?$errors["description_session"]:"" ?><br>
          </div>
        </div>

    <div class="form-group">
    	  <label><?= i18n("Time")?>:</label>
         <input type="text" class="form-control" name="time" value="">
         <div class="help-block">
          <?= isset($errors["time"])?$errors["time"]:"" ?><br>
          </div>
          </div>

    <div class="form-group">
    	 <label><?= i18n("Date")?>:</label>
        <input type="text"class="form-control" name="date" value="">
        <div class="help-block">
          <?= isset($errors["date"])?$errors["date"]:"" ?><br>
          </div>

    <div class="form-group">
          <input type="submit" class="btn btn-info" value= <?= i18n("Add")?> >
        </div>
      </div>
    </form>
</div>
