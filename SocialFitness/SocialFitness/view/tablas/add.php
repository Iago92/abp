<?php
 //file: view/maquinas/register.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $errors = $view->getVariable("errors");
 $exercises = $view->getVariable("exercises");
 $tabla = $view->getVariable("tabla");
 $selected = $view->getVariable("selected");
 $view->setVariable("title", "Add table");
?>


<div class="col-md-12 button-buffer">
  <h1><?= i18n("Add table")?></h1>
  <form action="index.php?controller=tablas&amp;action=add" method="POST">
    <div class="form-group">
      <label><?= i18n("Name")?>:</label>
      <input type="text" class="form-control" name="nombre"   value="<?= $tabla->getNombre() ?>">
      <div class="help-block">
        <?= isset($errors["nombre"])?$errors["nombre"]:"" ?>
      </div>
    </div>
    <div class="form-group">
          <label><?= i18n("Number of exercises")?>:</label>
            <input type="text" class="form-control" name="num_ejercicios" value="<?= $tabla->getNum_ejercicios() ?>">
            <div class="help-block">
              <?= isset($errors["num_ejercicios"])?$errors["num_ejercicios"]:"" ?>
            </div>
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
      </div>
      <div class="form-group">
            <label><?= i18n("Difficulty")?>:</label>
            <select name="dificultad" class="form-control">
              <option value="hard" selected> <?= i18n("Hard") ?> </option>
              <option value="medium"> <?= i18n("Medium") ?> </option>
              <option value="easy"> <?= i18n("Easy") ?> </option>
            </select>
            <div class="help-block">
              <?= isset($errors["dificultad"])?$errors["dificultad"]:"" ?>
       </div>
    </div>

    <div class="form-group">
      <label><?= i18n("Exercise tables")?>:</label>
      <?php if(count($exercises) > 0): ?>
          <select multiple class="select-con-buscador form-control" name="exercises[]">
            <?php
              foreach($exercises as $exercise){
            ?>
                <option value=" <?= $exercise->getId() ?>" <?php if ( in_array($exercise->getId(),$selected) ){echo "selected";} ?>>  <?= $exercise->getName() ?> </option>;
            <?php
              }
            ?>
          </select>
          <?php else: ?>
          <div class="alert alert-info">
                <?= i18n("There are no exercise tables defined")?>
          </div>
        <?php endif; ?>
      <div class="help-block">
        <?= isset($errors["raro"])?$errors["raro"]:"" ?>
      </div>
    </div>


    <input type="submit" class="btn btn-info" value= <?= i18n("Add")?> >
    </form>
    </div>
