<?php
 //file: view/posts/index.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();

 $session = $view->getVariable("session");
 $currentmaquina = $view->getVariable("currentmaquinaname");

 $view->setVariable("title", i18n("View session"));

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $currentuser = $view->getVariable("currentusername");
 $currentuserid = $view->getVariable("currentuserid");
 if (!isset($currentuser)){
   $view->redirect("users", "login");
 }

?><h1><?=i18n("View session")?></h1>

<table class="table table-striped table-condensed">
  <tr class="info">
    <th><?= i18n("Name")?></th>
    <th><?= i18n("Description")?></th>
  	<th><?= i18n("Time")?></th>
  	<th><?= i18n("Date")?></th>
  </tr>

  <tr>
    <td>
      <?= htmlentities( $session->getName() ) ?></a>
    </td>
    <td>
      <?= htmlentities( $session->getDescription() ) ?></a>
    </td>
    <td>
      <?= htmlentities( $session->getTime() ) ?></a>
    </td>
    <td>
      <?= htmlentities( $session->getDate() ) ?></a>
    </td>
  </tr>
</table>