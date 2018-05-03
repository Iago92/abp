<?php
 //file: view/posts/index.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();

 $tablas = $view->getVariable("tabla");
 $currentuser = $view->getVariable("currentusername");
 $currentusertype = $view->getVariable("currentusertype");


 $view->setVariable("title", "Tablas");

?>
<div class="col-md-12">
  <h1><?=i18n("Tables")?></h1>
  <?php
    if( $currentusertype == "coach"): ?>
      <p><a href="index.php?controller=tablas&amp;action=add" class="btn btn-info"><?= i18n("Add table") ?></a></p>
  <?php
    endif
  ?>
<table class="table table-striped table-condensed">
      <tr class="info">
        <th><?= i18n("Name")?></th>
        <th><?= i18n("Number of exercises")?></th>
        <th><?= i18n("Type")?></th>
        <th><?= i18n("Dificulty")?></th>
        <?php
          if( $currentusertype == "coach"): ?>
            <th><?= i18n("Management options")?></th>
        <?php
          endif
        ?>
      </tr>
       <?php foreach ($tablas as $tabla): ?>
      <tr>
        <td>
          <a href="index.php?controller=tablas&amp;action=view&amp;id=<?= $tabla->getId() ?>"><?= htmlentities( $tabla->getNombre() ) ?></a>
        </td>
        <td>
          <a href="index.php?controller=tablas&amp;action=view&amp;id=<?= $tabla->getId() ?>"><?= htmlentities( $tabla->getNum_ejercicios() ) ?></a>
        </td>
        <td>
          <a href="index.php?controller=tablas&amp;action=view&amp;id=<?= $tabla->getId() ?>"><?= htmlentities( $tabla->getTipo() ) ?></a>
        </td>
         <td>
          <a href="index.php?controller=tablas&amp;action=view&amp;id=<?= $tabla->getId() ?>"><?= htmlentities( $tabla->getDificultad() ) ?></a>
        </td>
        
        <?php
         if( $currentusertype == "coach"): ?>
            <td>
              <a href="index.php?controller=tablas&amp;action=delete&amp;id=<?= $tabla->getId() ?>" class="btn btn-danger"><?= i18n("Delete") ?></a>
              <a href="index.php?controller=tablas&amp;action=edit&amp;id=<?= $tabla->getId() ?>" class="btn btn-warning"><?= i18n("Edit") ?></a>
            </td>
        <?php
          endif
        ?>
      </tr>
    <?php endforeach; ?>
    </table>
    </div>

