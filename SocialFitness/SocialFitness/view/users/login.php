<?php
 //file: view/users/login.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $view->setVariable("title", "Login");
 $errors = $view->getVariable("errors");
?>
<div class="col-md-12 button-buffer">
  <h1><?= i18n("Login") ?></h1>
  <?= isset($errors["general"])?$errors["general"]:"" ?>

  <form action="index.php?controller=users&amp;action=login" method="POST">
    <div class="form-group">
      <label><?= i18n("Email")?>:</label>
      <input type="text" class="form-control" name="email">
    </div>

    <div class="form-group">
      <label><?= i18n("Password")?>:</label>
      <input type="password" class="form-control" name="password">
    </div>
    <input type="submit" class="btn btn-success" value="<?= i18n("Login") ?>">
  </form>
</div>