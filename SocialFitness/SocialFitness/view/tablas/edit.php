<?php
 //file: view/maquinas/register.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $errors = $view->getVariable("errors");
 $tabla = $view->getVariable("tabla");
 $exercises = $view->getVariable("exercises");
 $selected = $view->getVariable("selected");
 $view->setVariable("title", "edit");
?>

<div class="col-md-12 button-buffer">
  <h1><?= i18n("Edit table")?></h1>
  <form action="index.php?controller=tablas&amp;action=edit&amp;id=<?= $tabla->getId() ?>" method="POST">
  <div class="form-group">
      <label><?= i18n("Name")?>:</label>
      <input type="text" class="form-control" name="nombre"	value="<?= $tabla->getNombre() ?>">
      <?= isset($errors["nombre"])?$errors["nombre"]:"" ?>
  </div>
  <div class="form-group">
      <label><?= i18n("Number of exercises")?>:</label>
      <input type="text" class="form-control" name="num_ejercicios"	value="<?= $tabla->getNum_ejercicios() ?>">
      <?= isset($errors["num_ejercicios"])?$errors["num_ejercicios"]:"" ?>
  </div>
  <div class="form-group">
            <label><?= i18n("Type")?>:</label>
            <select name="tipo" class="form-control">
              <option value="resistencia" selected> <?= i18n("Resistance") ?> </option>
              <option value="flexibilidad"> <?= i18n("Flexibility") ?> </option>
              <option value="fuerza"> <?= i18n("Strengh") ?> </option>
            </select>
            <div class="help-block">
              <?= isset($errors["tipo"])?$errors["tipo"]:"" ?>
  </div>

   <div class="form-group">
            <label><?= i18n("Dificulty")?>:</label>
            <select name="dificultad" class="form-control">
              <option value="hard" selected> <?= i18n("Hard") ?> </option>
              <option value="medium"> <?= i18n("Medium") ?> </option>
              <option value="easy"> <?= i18n("Easy") ?> </option>
            </select>
            <div class="help-block">
              <?= isset($errors["dificultad"])?$errors["dificultad"]:"" ?>
   </div>

   <div class="form-group">
     <label><?= i18n("Exercises")?>:</label>
     <?php if(count($exercises) > 0): ?>
     <select multiple class="form-control" name="exercises[]">
       <?php var_dump($exercises);
         foreach($exercises as $exercise){
       ?>
         <option value="<?= $exercise->getId() ?>" <?php if ( in_array($exercise->getId(),$selected) ){echo "selected";} ?>>  <?= $exercise->getName() ?> </option>;
       <?php
         }
       ?>
     </select>
   <?php else: ?>
     <div class="alert alert-info">
       <?= i18n("There are no exercises defined")?>
     </div>
     <?php endif; ?>
     <div class="help-block">
       <?= isset($errors["exercise"])?$errors["exercise"]:"" ?>
     </div>
   </div>

    <input type="submit" class="btn btn-warning" name="submit" value="<?= i18n("Edit")?>">

  </form>
</div>

