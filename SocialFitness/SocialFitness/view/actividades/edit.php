<?php
 //file: view/maquinas/register.php
 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $errors = $view->getVariable("errors");
 $actividad = $view->getVariable("actividad");
 $coaches = $view->getVariable("coaches");
 $view->setVariable("title", "edit");
?>

<div class="col-md-12 button-buffer">
  <h1><?= i18n("Editar actividad")?></h1>
  <form action="index.php?controller=actividades&amp;action=edit&amp;id=<?= $actividad->getId() ?>" method="POST">
  <div class="form-group">
      <label><?= i18n("Nombre")?>:</label>
      <input type="text" class="form-control" name="nombre" value="<?= $actividad->getNombre() ?>">
      <?= isset($errors["nombre"])?$errors["nombre"]:"" ?>
  </div>

  <div class="form-group">
      <label><?= i18n("Horario")?>:</label>
      <input type="text" class="form-control" name="horario" value="<?= $actividad->getHorario() ?>">
      <?= isset($errors["horario"])?$errors["horario"]:"" ?>
  </div>

  <div class="form-group">
      <label><?= i18n("Descripcion")?>:</label>
      <input type="text" class="form-control" name="descripcion" value="<?= $actividad->getDescripcion() ?>">
      <?= isset($errors["descripcion"])?$errors["descripcion"]:"" ?>
  </div>

  <div class="form-group">
      <label><?= i18n("Numero de plazas")?>:</label>
      <input type="text" class="form-control" name="num_plazas" value="<?= $actividad->getNum_plazas() ?>">
      <?= isset($errors["num_plazas"])?$errors["num_plazas"]:"" ?>
  </div>

  <div class="form-group">
    <label><?= i18n("Coach")?>:</label>
    <select name="coach" class="form-control">
      <?php foreach ($coaches as $coach): ?>
        <option value="<?= $coach->getId() ?>" <?php if($coach->getId()==$actividad->getEntrenador()->getId()){echo "selected";} ?> > <?= $coach->getName() ?> </option>
      <?php endforeach; ?>
    </select>
    <?= isset($errors["coach"])?$errors["coach"]:"" ?>
  </div>


  <input type="submit" class="btn btn-warning" name="submit" value="<?= i18n("Edit")?>">
  </form>

</div>