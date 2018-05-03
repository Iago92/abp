<?php
 //file: view/maquinas/register.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $errors = $view->getVariable("errors");
 $maquina = $view->getVariable("maquina");
 $view->setVariable("title", "Add maquina");
?>
<div class="col-md-12">

  <h1><?= i18n("Add maquina")?></h1>
  <form action="index.php?controller=maquinas&amp;action=add" method="POST">
    <div class="form-group">
      <label><?= i18n("Full name")?>:</label>
      <input type="text" class="form-control" name="name"	value="<?= $maquina->getName() ?>">
      <?= isset($errors["name"])?$errors["name"]:"" ?><br>
    </div>

    <div class="form-group">
			<label><?= i18n("Location")?>:</label>
      <input type="text" class="form-control" name="ubicacion" value="<?= $maquina->getUbicacion() ?>">
      <?= isset($errors["ubicacion"])?$errors["ubicacion"]:"" ?>
    </div>

        <input type="submit" class="btn btn-info" value= <?= i18n("Add")?> >
  </form>

</div>
