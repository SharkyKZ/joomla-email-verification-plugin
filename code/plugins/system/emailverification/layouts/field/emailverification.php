<?php
/**
 * @copyright   (C) 2022 SharkyKZ
 * @license     GPL-2.0-or-later
 */
defined('_JEXEC') || exit;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;

extract($displayData);

$app->getDocument()->addScriptOptions(
	'plg_system_emailverification',
	array(
		'url' => Route::_('index.php?option=com_ajax&plugin=emailVerification&group=system&format=json', false, false, Route::TLS_IGNORE, true),
		'messageId' => $messageId,
		'buttonId' => $buttonId,
		'classes' => array(
			'success' => array('text-success'),
			'error' => array('text-danger'),
		)
	)
);

HTMLHelper::_('behavior.core');
HTMLHelper::_('script', 'plg_system_emailverification/script.js', array('relative' => true));
?>
<button id="<?= $this->escape($buttonId) ?>" type="button" class="btn btn-primary"><?= $app->getLanguage()->_('PLG_SYSTEM_EMAILVERIFICATION_FIELD_BUTTON') ?></button>
<div id="<?= $this->escape($messageId) ?>"></div>
<noscript><div><?= $app->getLanguage()->_('PLG_SYSTEM_EMAILVERIFICATION_NOSCRIPT'); ?></div></noscript>
