<?php
 //file: view/posts/index.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();

 $actividades = $view->getVariable("actividad");
 $currentuser = $view->getVariable("currentusername");
 $currentusertype = $view->getVariable("currentusertype");
 $errors = $view->getVariable("errors");


 $view->setVariable("title", i18n("Activity  management"));

?>

<div class="col-md-12">
  <h1><?=i18n("Activities")?></h1>
  <?php
    if( $currentusertype == "admin"): ?>
      <p><a href="index.php?controller=actividades&amp;action=add" class="btn btn-info"><?= i18n("Add activity") ?></a></p>
  <?php
    endif
  ?>
  <?php
  if(isset($errors["activity"])){
  ?>
    <div class="alert alert-danger">
      <?= $errors["activity"] ?>
    </div>
  <?php
  }
  ?>

  <table class="table table-striped table-condensed">
      <tr class="info">
        <th><?= i18n("Name")?></th>
        <th><?= i18n("Schedule")?></th>
        <th><?= i18n("Description")?></th>
        <th><?= i18n("Seating Capacity")?></th>
        <th><?= i18n("Coach")?></th>
        <th><?= i18n("Inscription")?></th>
        <?php
          if( $currentusertype == "admin"): ?>
            <th><?= i18n("Management options")?></th>
        <?php
          endif
        ?>
      </tr>
      <?php foreach ($actividades as $actividad): ?>
      <tr>
        <td>
          <a href="index.php?controller=actividades&amp;action=view&amp;id=<?= $actividad->getId() ?>"><?= htmlentities( $actividad->getNombre() ) ?></a>
        </td>
        <td>
          <a href="index.php?controller=actividades&amp;action=view&amp;id=<?= $actividad->getId() ?>"><?= htmlentities( $actividad->getHorario() ) ?></a>
        </td>
        <td>
          <a href="index.php?controller=actividades&amp;action=view&amp;id=<?= $actividad->getId() ?>"><?= htmlentities( $actividad->getDescripcion() ) ?></a>
        </td>
         <td>
          <a href="index.php?controller=actividades&amp;action=view&amp;id=<?= $actividad->getId() ?>"><?= htmlentities( $actividad->getNum_plazas() ) ?></a>
        </td>
         <td>
           <a href="index.php?controller=actividades&amp;action=view&amp;id=<?= $actividad->getId() ?>"><?= htmlentities( $actividad->getEntrenador()->getName() ) ?></a>
         </td>
         <td>
           <a href="index.php?controller=actividades&amp;action=inscription&amp;id=<?= $actividad->getId() ?>" class="btn btn-success"><?= i18n("Sign up") ?></a>
         </td>
        <?php
          if( $currentusertype == "admin"): ?>
            <td>
              <a href="index.php?controller=actividades&amp;action=delete&amp;id=<?= $actividad->getId() ?>" class="btn btn-danger"><?= i18n("Delete") ?></a>
              <a href="index.php?controller=actividades&amp;action=edit&amp;id=<?= $actividad->getId() ?>" class="btn btn-warning"><?= i18n("Edit") ?></a>
            </td>
        <?php
          endif
        ?>
      </tr>
    <?php endforeach; ?>
    </table>
</div>


