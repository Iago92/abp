<?php
//file: view/posts/index.php

  require_once(__DIR__."/../../core/ViewManager.php");
  $view = ViewManager::getInstance();

  $sessions = $view->getVariable("sessions");
  $currentsession = $view->getVariable("currentsessionname");

  $view->setVariable("title", i18n("Sessions"));
?>


<div class="col-md-12">
    <h1><?=i18n("Sessions")?></h1>

  <?php //if (isset($currentsession)): ?>
      <a href="index.php?controller=sessions&amp;action=add"class="btn btn-info"><?= i18n("Add session") ?></a>
  <?php //endif; ?>
<br> </br>
<table class="table table-striped table-condensed">
  <tr class="info">
  <th><?= i18n("Name")?></th>
  <th><?= i18n("Description")?></th>
	<th><?= i18n("Time")?></th>
	<th><?= i18n("Date")?></th>
  <th><?= i18n("Options")?></th>

  </tr>

  <?php foreach ($sessions as $session): ?>
  <tr>

    <td>
      <a href="index.php?controller=sessions&amp;action=view&amp;id=<?= $session->getId() ?>"><?= htmlentities( $session->getName() ) ?></a>
    </td>
    <td>
      <a href="index.php?controller=sessions&amp;action=view&amp;id=<?= $session->getId() ?>"><?= htmlentities( $session->getDescription() ) ?></a>
    </td>
	<td>
      <a href="index.php?controller=sessions&amp;action=view&amp;id=<?= $session->getId() ?>"><?= htmlentities( $session->getTime() ) ?></a>
    </td>
    <td>
      <a href="index.php?controller=sessions&amp;action=view&amp;id=<?= $session->getId() ?>"><?= htmlentities( $session->getDate() ) ?></a>
    </td>
    <td>
      <a href="index.php?controller=sessions&amp;action=delete&amp;id=<?= $session->getId() ?>"class="btn btn-danger"><?= i18n("Delete") ?></a>

      <a href="index.php?controller=sessions&amp;action=edit&amp;id=<?= $session->getId() ?>"class="btn btn-warning"><?= i18n("Edit") ?></a>
    </td>
  </tr>
<?php endforeach; ?>
</table>


</table>
</div>
