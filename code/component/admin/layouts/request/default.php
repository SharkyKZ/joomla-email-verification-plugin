<?php

\defined('_JEXEC') || exit;

?>
<?php foreach ($form->getFieldsets() as $name => $fieldset) : ?>
    <?= $form->renderFieldset($name) ?>
<?php endforeach ?>
<button type="submit" class="btn btn-primary"><?= $language->_('JSUBMIT') ?></button>
