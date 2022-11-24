<?php
/**
 * @copyright   (C) 2022 SharkyKZ
 * @license     GPL-2.0-or-later
 */
defined('_JEXEC') || exit;

use Joomla\CMS\HTML\HTMLHelper;

extract($displayData);

$document->addScriptOptions(
	'plg_system_emailverification',
	array(
		'messageId' => $messageId,
		'buttonId' => $buttonId,
		'classes' => array(
			'success' => array('text-success'),
			'error' => array('text-danger'),
		)
	)
);

HTMLHelper::_('behavior.core');
HTMLHelper::_('script', 'plg_system_emailverification/script.js', array('relative' => true, 'version' => $scriptHash), array('defer' => true, 'async' => true));
?>
<div>
	<button id="<?= $this->escape($buttonId) ?>" type="button" class="btn btn-primary"><?= $language->_('PLG_SYSTEM_EMAILVERIFICATION_FIELD_BUTTON') ?></button>
</div>
<div id="<?= $this->escape($messageId) ?>"></div>
<br>
<noscript><div><?= $language->_('PLG_SYSTEM_EMAILVERIFICATION_NOSCRIPT'); ?></div></noscript>
