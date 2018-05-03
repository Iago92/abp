<?php
 //file: view/layouts/default.php

 require_once(__DIR__."/../../core/ViewManager.php");
 $view = ViewManager::getInstance();
 $currentuser = $view->getVariable("currentusername");
 $currentuserid = $view->getVariable("currentuserid");
 if (!isset($currentuser)){
   $view->redirect("users", "login");
 }
?><!DOCTYPE html>
<html>
  <head>
    <title><?= $view->getVariable("title", "no title") ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="public/css/style.css" type="text/css">
    <link rel="stylesheet" href="public/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="public/css/style.min.css" type="text/css">
    <link rel="stylesheet" href="public/css/bootstrap-multiselect.min.css" type="text/css">
    <link rel="stylesheet" href="public/css/flags.css" type="text/css">
    <?= $view->getFragment("css") ?>
    <?= $view->getFragment("javascript") ?>
  </head>
  <body>
    <?php
      $class = $_GET['controller']=="users"?  "class=active": '';
     ?>
    <!-- header -->
    <header class="col-md-12">
      <h1>SocialFitness</h1>
      <h3><?= sprintf(i18n("Logged as %s"), $currentuser) ?></h3  >
      <nav id="menu">
      	<ul class="nav nav-tabs">
        	<li class=<?php if ($_GET['controller']=="users") {echo "active"; } else {echo "noactive";}?>>
            <a href="index.php?controller=users&amp;action=index"><?= i18n("Users") ?></a>
          </li>
          <li class=<?php if ($_GET['controller']=="exercises") {echo "active"; } else {echo "noactive";}?>>
            <a href="index.php?controller=exercises&amp;action=index"><?= i18n("Exercises") ?></a>
          </li>
          <li class=<?php if ($_GET['controller']=="maquinas") {echo "active"; } else {echo "noactive";}?>>
            <a href="index.php?controller=maquinas&amp;action=index"><?= i18n("Machines") ?></a>
          </li>
           <li class=<?php if ($_GET['controller']=="actividades") {echo "active"; } else {echo "noactive";}?>>
            <a href="index.php?controller=actividades&amp;action=index"><?= i18n("Activities") ?></a>
          </li>
          <li class=<?php if ($_GET['controller']=="tabla") {echo "active"; } else {echo "noactive";}?>>
            <a href="index.php?controller=tablas&amp;action=index"><?= i18n("Tables") ?></a>
          </li>
          <li class=<?php if ($_GET['controller']=="tabla") {echo "active"; } else {echo "noactive";}?>>
            <a href="index.php?controller=sessions&amp;action=index&amp;id=<?= $currentuserid ?>"><?= i18n("Sessions") ?></a>
          </li>
          <a href="index.php?controller=users&amp;action=logout" class="btn btn-default pull-right"><?= i18n("Logout") ?></a>
      	</ul>
      </nav>
    </header>
    <div id="flash" >
      <?= $view->popFlash() ?>
    </div>

    <main class="col-md-12">

      <?= $view->getFragment(ViewManager::DEFAULT_FRAGMENT) ?>
    </main>

    <footer>
      <?php
      include(__DIR__."/language_select_element.php");
      ?>
    </footer>

  </body>
</html>