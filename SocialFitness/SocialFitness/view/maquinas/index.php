<?php
//file: view/posts/index.php

  require_once(__DIR__."/../../core/ViewManager.php");
  $view = ViewManager::getInstance();

  $maquinas = $view->getVariable("maquinas");
  $currentmaquina = $view->getVariable("currentmaquinaname");

  $view->setVariable("title", i18n("Maquinas"));
?>
<div class="col-md-12">
<h1><?=i18n("Gestion Maquinas")?></h1>

<?php //if (isset($currentmaquina)): ?>
<div class="form-group">
  <a href="index.php?controller=maquinas&amp;action=add" class="btn btn-info"><?= i18n("Add machine") ?></a>
</div>
<?php //endif; ?>
<table class="table table-striped table-condensed">
<tr class="info">

    <th><?= i18n("Name")?></th>
    <th><?= i18n("Location")?></th>
    <th><?= i18n("Options")?></th>

</tr>
  <?php foreach ($maquinas as $maquina): ?>
  <tr>
    <td>
      <a href="index.php?controller=maquinas&amp;action=view&amp;id=<?= $maquina->getId() ?>"><?= htmlentities( $maquina->getName() ) ?></a>
    </td>
    <td>
      <a href="index.php?controller=maquinas&amp;action=view&amp;id=<?= $maquina->getId() ?>"><?= htmlentities( $maquina->getUbicacion() ) ?></a>
    </td>
    <td>
      <a href="index.php?controller=maquinas&amp;action=delete&amp;id=<?= $maquina->getId() ?>" class="btn btn-danger"><?= i18n("Delete") ?></a>

      <a href="index.php?controller=maquinas&amp;action=edit&amp;id=<?= $maquina->getId() ?>" class="btn btn-warning"><?= i18n("Edit") ?></a>
    </td>
  </tr>
<?php endforeach; ?>
</table>

  </table>
</div>
