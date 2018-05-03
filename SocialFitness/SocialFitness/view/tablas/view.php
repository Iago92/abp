<?php
 //file: view/posts/index.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();

 $tabla = $view->getVariable("tabla");
 $exercises = $view->getVariable("exercises");
 $selected = $view->getVariable("selected");

 $view->setVariable("title", i18n("View table"));

?>

<div class="col-md-12">

  <h1><?=i18n("View table")?></h1>

  <table class="table table-striped table-condensed">
    <tr class="info">
        <th><?= i18n("Name")?></th>
        <th><?= i18n("Number of exercises")?></th>
        <th><?= i18n("Type")?></th>
        <th><?= i18n("Dificulty")?></th>

    </tr>
  <tr>
    <td>
      <?= htmlentities( $tabla->getNombre() ) ?></a>
    </td>
    <td>
      <?= htmlentities( $tabla->getNum_ejercicios() ) ?></a>
    </td>
    <td>
      <?= htmlentities( $tabla->getTipo() ) ?></a>
    </td>
    <td>
      <?= htmlentities( $tabla->getDificultad() ) ?></a>
    </td>
  </tr>
</table>

<h4><?=i18n("Exercises")?></h4>
<table class="table table-striped table-condensed">
  <tr class="info">
    <th><?= i18n("Name")?></th>
    <th><?= i18n("Details")?></th>
    <th><?= i18n("Dificulty")?></th>
    <th><?= i18n("Type")?></th>
    <th><?= i18n("Machine")?></th>
  </tr>

  <?php
    foreach ($exercises as $exercise):
      if ( in_array($exercise->getId(),$selected) ){
  ?>
    <tr>
      <td>
        <a href="index.php?controller=exercises&amp;action=view&amp;id=<?= $exercise->getId() ?>"><?= htmlentities( $exercise->getName() ) ?></a>
      </td>
      <td>
        <a href="index.php?controller=exercises&amp;action=view&amp;id=<?= $exercise->getId() ?>"><?= htmlentities( $exercise->getDetails() ) ?></a>
      </td>
      <td>
        <a href="index.php?controller=exercises&amp;action=view&amp;id=<?= $exercise->getId() ?>"><?= htmlentities( $exercise->getType() ) ?></a>
      </td>
      <td>
        <a href="index.php?controller=exercises&amp;action=view&amp;id=<?= $exercise->getId() ?>"><?= htmlentities( $exercise->getType() ) ?></a>
      </td>
      <td>
        <a href="index.php?controller=exercises&amp;action=view&amp;id=<?= $exercise->getId() ?>"><?= htmlentities( $exercise->getMachine()->getName() ) ?></a>
      </td>
    </tr>
  <?php
    }
    endforeach;
  ?>
</table>
