<?php
 //file: view/posts/index.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();

 $exercise = $view->getVariable("exercise");
 $currentuser = $view->getVariable("currentusername");

 $view->setVariable("title", i18n("View exercise"));
?>
<div class="col-md-12">

  <h1><?=i18n("View exercise")?></h1>

  <table class="table table-striped table-condensed">
    <tr class="info">
        <th><?= i18n("Name")?></th>
        <th><?= i18n("Type")?></th>
        <th><?= i18n("Difficulty")?></th>
        <th><?= i18n("Machine")?></th>
    </tr>

    <tr>
      <td>
        <?= htmlentities( $exercise->getName() ) ?></a>
      </td>
      <td>
        <?= htmlentities( $exercise->getType() ) ?></a>
      </td>
      <td>
        <?= htmlentities( $exercise->getDifficulty() ) ?></a>
      </td>
      <td>
        <?= htmlentities( $exercise->getMachine()->getName() ) ?></a>
      </td>
    </tr>
  </table>
  <h4><?= i18n("Details")?></h4>
  <?=$exercise->getDetails();?>
</div>



