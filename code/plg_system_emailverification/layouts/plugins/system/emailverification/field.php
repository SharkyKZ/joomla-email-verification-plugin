<?php
/**
 * @copyright   (C) 2022 SharkyKZ
 * @license     GPL-2.0-or-later
 */
defined('_JEXEC') || exit;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

extract($displayData);
?>
<div class="input-group">
	<?= $input ?>
	<?= HTMLHelper::_('link', $requestLink, Text::_('COM_EMAILVERIFICATION_CHANGE_EMAIL'), ['class' => 'btn btn-primary']) ?>
</div>
