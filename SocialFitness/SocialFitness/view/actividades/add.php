<?php
 //file: view/maquinas/register.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $errors = $view->getVariable("errors");
 $actividad = $view->getVariable("actividad");
 $coaches = $view->getVariable("coaches");
 $view->setVariable("title", "Add activity");
?>


<div class="col-md-12 button-buffer">
  <h1><?= i18n("Add activity")?></h1>
  <form action="index.php?controller=actividades&amp;action=add" method="POST">
    <div class="form-group">
      <label><?= i18n("Name")?>:</label>
      <input type="text" class="form-control" name="nombre"   value="">
      <div class="help-block">
        <?= isset($errors["nombre"])?$errors["nombre"]:"" ?>
      </div>
    </div>

    <div class="form-group">
      <label><?= i18n("Schedule")?>:</label>
      <input type="text" class="form-control" name="horario"   value="">
      <div class="help-block">
        <?= isset($errors["horario"])?$errors["horario"]:"" ?>
      </div>
    </div>

    <div class="form-group">
      <label><?= i18n("Description")?>:</label>
      <input type="text" class="form-control" name="descripcion"   value="">
      <div class="help-block">
        <?= isset($errors["descripcion"])?$errors["descripcion"]:"" ?>
      </div>
    </div>

    <div class="form-group">
      <label><?= i18n("Seating Capacity")?>:</label>
      <input type="text" class="form-control" name="num_plazas"   value="">
      <div class="help-block">
        <?= isset($errors["num_plazas"])?$errors["num_plazas"]:"" ?>
      </div>
    </div>

    <div class="form-group">
      <label><?= i18n("Coach")?>:</label>
      <select name="coach" class="form-control">
        <?php foreach ($coaches as $coach): ?>
          <option value="<?= $coach->getId() ?>" <?php if($coach->getId()==$actividad->getEntrenador()){echo "selected";} ?> > <?= $coach->getName() ?> </option>
        <?php endforeach; ?>
      </select>
      <?= isset($errors["coach"])?$errors["coach"]:"" ?>
    </div>


    <input type="submit" class="btn btn-info" value= <?= i18n("Add")?> >
    </form>
    </div>
