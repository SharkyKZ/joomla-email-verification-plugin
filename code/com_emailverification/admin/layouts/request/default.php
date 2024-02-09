<?php

defined('_JEXEC') || exit;

?>
<form action="<?= $router->build('index.php?option=com_emailverification&task=request') ?>" method="post">
<?php foreach ($form->getFieldsets() as $name => $fieldset) : ?>
	<fieldset>
		<legend><?= $language->_($fieldset->label) ?></legend>
		<?= $form->renderFieldset($name) ?>
	</fieldset>
<?php endforeach ?>
<button type="submit" class="btn btn-primary"><?= $language->_('JSUBMIT') ?></button>
</form>
