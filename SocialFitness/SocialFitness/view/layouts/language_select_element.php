<?php
// file: view/layouts/language_select_element.php
?>
<div id="languagechooser" class="btn-group col-md-12" id="footer">
	<br/>
	<a class="btn btn-default" href="index.php?controller=language&amp;action=change&amp;lang=en">
			<span class="flag flag-us" alt="English" lang="en"></span> <?= i18n("English") ?>

	</a>
	<a class="btn btn-default" href="index.php?controller=language&amp;action=change&amp;lang=es">
			<span class="flag flag-es" alt="English" lang="es"></span> <?= i18n("Spanish") ?>
	</a>
</div>