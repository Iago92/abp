<?php
 //file: view/posts/index.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();

 $maquina = $view->getVariable("maquina");
 $currentmaquina = $view->getVariable("currentmaquinaname");

 $view->setVariable("title", i18n("View machine"));

?><h1><?=i18n("View machine")?></h1>

<table class="table table-striped table-condensed">
  <tr class="info">
    <th><?= i18n("Name")?></th>
    <th><?= i18n("Location")?></th>

  </tr>

  <tr>
    <td>
      <?= htmlentities( $maquina->getName() ) ?></a>
    </td>
    <td>
      <?= htmlentities( $maquina->getUbicacion() ) ?></a>
    </td>

  </tr>
</table>
