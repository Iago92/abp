<?php
 //file: view/posts/index.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();

 $actividad = $view->getVariable("actividad");
 $users = $view->getVariable("users");
 $selected = $view->getVariable("selected");
 $currentuserid = $view->getVariable("currentuserid");


 $view->setVariable("title", i18n("View activity"));

?>
<div class="col-md-12">

  <h1><?=i18n("View Activity")?></h1>

  <table class="table table-striped table-condensed">
    <tr class="info">
        <th><?= i18n("Name")?></th>
        <th><?= i18n("Schedule")?></th>
        <th><?= i18n("Description")?></th>
        <th><?= i18n("Seating Capacity")?></th>
        <th><?= i18n("Coach")?></th>
    </tr>

  <tr>
    <td>
      <?= htmlentities( $actividad->getNombre() ) ?></a>
    </td>
    <td>
      <?= htmlentities( $actividad->getHorario() ) ?></a>
    </td>
    <td>
      <?= htmlentities( $actividad->getDescripcion() ) ?></a>
    </td>
    <td>
      <?= htmlentities( $actividad->getNum_plazas() ) ?></a>
    </td>
    <td>
      <?= htmlentities( $actividad->getEntrenador()->getName() ) ?></a>
    </td>

  </tr>
</table>

<h4><?=i18n("Assigned training tables")?></h4>
<table class="table table-striped table-condensed">
  <tr class="info">
    <th><?= i18n("Name")?></th>
    <th><?= i18n("Number of exercises")?></th>
    <th><?= i18n("Type")?></th>
    <th><?= i18n("Dificulty")?></th>
    <th><?= i18n("Management options")?></th>
  </tr>

  <?php
    foreach ($users as $user):
      if ( in_array($user->getId(),$selected) ){
  ?>
    <tr>
      <td>
        <a href="index.php?controller=users&amp;action=view&amp;id=<?= $user->getId() ?>"><?= htmlentities( $user->getName() ) ?></a>
      </td>
      <td>
        <a href="index.php?controller=users&amp;action=view&amp;id=<?= $user->getId() ?>"><?= htmlentities( $user->getEmail() ) ?></a>
      </td>
      <td>
        <a href="index.php?controller=users&amp;action=view&amp;id=<?= $user->getId() ?>"><?= htmlentities( $user->getType() ) ?></a>
      </td>
      <td>
        <a href="index.php?controller=users&amp;action=view&amp;id=<?= $user->getId() ?>"><?= htmlentities( $user->getPhone() ) ?></a>
      </td>
      <td>
        <?php
          if( ($currentuserid == $actividad->getEntrenador()->getId()) || ($currentuserid == $user->getId() ) ): ?>
              <a href="index.php?controller=actividades&amp;action=leave&amp;id=<?= $actividad->getId() ?>&amp;user=<?= $user->getId() ?>" class="btn btn-danger"><?= i18n("Leave") ?></a>
        <?php
          endif
        ?>
      </td>
    </tr>
  <?php
    }
    endforeach;
  ?>
</table>
