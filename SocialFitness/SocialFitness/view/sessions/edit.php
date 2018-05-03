<?php
 //file: view/maquinas/register.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $errors = $view->getVariable("errors");
 $session = $view->getVariable("session");
 $view->setVariable("title", "Edit session");
////////////////////////////////////////////////////////
$currentuser = $view->getVariable("currentusername");
$currentuserid = $view->getVariable("currentuserid");
if (!isset($currentuser)){
  $view->redirect("users", "login");
}
///////////////////////////////////////////////////////////
?>

<div class="col-md-12 button-buffer">
<h1><?= i18n("Edit session")?></h1>
<div class="col-md-6">
<form action="index.php?controller=sessions&amp;action=edit&amp;id=<?= $session->getID() ?>" method="POST">
    <div class="form-group">
      <label><?= i18n("Name")?>:</label>
       <input type="text" class="form-control" name="name"	value="<?= $session->getName() ?>" >
       <div class="help-block">
      <?= isset($errors["name"])?$errors["name"]:"" ?><br>
    </div>
  </div>

    <div class="form-group" >
      <label><?= i18n("Description")?>:</label>
       <input type="text" class="form-control" name="description_session" value="<?= $session->getDescription() ?>">
       <div class="help-block">
      <?= isset($errors["description_session"])?$errors["description_session"]:"" ?><br>
      </div>
    </div>

    <div class="form-group">
      <label><?= i18n("Time")?>:</label>
       <input type="text" class="form-control" name="time" value="<?= $session->getTime() ?>">
       <div class="help-block">
      <?= isset($errors["time"])?$errors["time"]:"" ?><br>
      </div>
    </div>

    <div class="form-group">
      <label><?= i18n("Date")?>:</label>
       <input type="text" class="form-control" name="date" value="<?= $session->getDate() ?>">
       <div class="help-block">
      <?= isset($errors["date"])?$errors["date"]:"" ?><br>
      </div>
    </div>

      <input type="submit" class="btn btn-info" name="submit" value= <?= i18n("Edit")?> >
</form>

  </div>
</div>
