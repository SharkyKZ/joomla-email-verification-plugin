<?php
/**
 * @copyright   (C) 2022 SharkyKZ
 * @license     GPL-2.0-or-later
 */
namespace Sharky\Plugin\System\EmailVerification\Rule;

use Joomla\Application\SessionAwareWebApplicationInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\Rule\EmailRule as CoreEmailRule;
use Joomla\Registry\Registry;

\defined('_JEXEC') || exit;

final class EmailRule extends CoreEmailRule
{
	public function test(\SimpleXMLElement $element, $value, $group = null, ?Registry $input = null, ?Form $form = null)
	{
		$app = Factory::getApplication();

		if (!$app instanceof SessionAwareWebApplicationInterface)
		{
			return parent::test($element, $value, $group, $input, $form);
		}

		$session = $app->getSession();

		if (!$session->has('com_emailverification.email'))
		{
			return false;
		}

		if ($session->get('com_emailverification.email') !== $value)
		{
			return false;
		}

		return parent::test($element, $value, $group, $input, $form);
	}
}
