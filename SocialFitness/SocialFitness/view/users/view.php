<?php
 //file: view/posts/index.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();

 $user = $view->getVariable("user");
 $tables = $view->getVariable("tables");
 $selected = $view->getVariable("selected");
 $currentuser = $view->getVariable("currentusername");
 $currentuserid = $view->getVariable("currentuserid");
 $currentusertype = $view->getVariable("currentusertype")
 ?>
 <div class="col-md-12">
  <?php
    $view->setVariable("title", i18n("View user"));
  ?>
  <h1><?=i18n("View user")?></h1>
  <?php
    if( $currentuserid == $user->getId() ||
        $currentusertype == 'coach'
    ): ?>
      <p><a href="index.php?controller=users&amp;action=selfedit&amp;id=<?= $user->getId() ?>" class="btn btn-warning"><?= i18n("Edit profile"); ?></a></p>
  <?php
    endif
  ?>
  <table class="table table-striped table-condensed">
    <tr class="info">
      <th><?= i18n("Name")?></th>
      <th><?= i18n("Email")?></th>
      <th><?= i18n("Type")?></th>
      <th><?= i18n("Phone")?></th>
    </tr>

    <tr>
      <td>
        <?= htmlentities( $user->getName() ) ?></a>
      </td>
      <td>
        <?= htmlentities( $user->getEmail() ) ?></a>
      </td>
      <td>
        <?= htmlentities( $user->getType() ) ?></a>
      </td>
      <td>
        <?= htmlentities( $user->getPhone() ) ?></a>
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
    </tr>

    <?php
      foreach ($tables as $table):
        if ( in_array($table->getId(),$selected) ){
    ?>
      <tr>
        <td>
          <a href="index.php?controller=tablas&amp;action=view&amp;id=<?= $table->getId() ?>"><?= htmlentities( $table->getNombre() ) ?></a>
        </td>
        <td>
          <a href="index.php?controller=tablas&amp;action=view&amp;id=<?= $table->getId() ?>"><?= htmlentities( $table->getNum_ejercicios() ) ?></a>
        </td>
        <td>
          <a href="index.php?controller=tablas&amp;action=view&amp;id=<?= $table->getId() ?>"><?= htmlentities( $table->getTipo() ) ?></a>
        </td>
         <td>
          <a href="index.php?controller=tablas&amp;action=view&amp;id=<?= $table->getId() ?>"><?= htmlentities( $table->getDificultad() ) ?></a>
        </td>
      </tr>
    <?php
      }
      endforeach;
    ?>
  </table>
</div>