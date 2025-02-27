<?php
/**
 * @copyright   (C) 2022 SharkyKZ
 * @license     GPL-2.0-or-later
 */
namespace Sharky\Plugin\System\EmailVerification\Field;

use Joomla\CMS\Form\Field\EmailField as CoreEmailField;
use Joomla\CMS\Plugin\PluginHelper;

\defined('_JEXEC') || exit;

final class EmailField extends CoreEmailField
{
	protected string $requestLink = '';

	public function setup(\SimpleXMLElement $element, $value, $group = null)
	{
		$return = parent::setup($element, $value, $group);

		if ($return)
		{
			$this->requestLink = (string) $this->element['requestLink'];
		}

		return $return;
	}

	protected function getInput(): string
	{
		$input = parent::getInput();
		$data = $this->collectLayoutData();
		$data['input'] = $input;

		return $this->render('plugins.system.emailverification.field', $data);
	}

	protected function getLayoutPaths(): array
	{
		$paths = parent::getLayoutPaths();
		$paths[] = \JPATH_PLUGINS . '/system/emailverification/layouts';

		return $paths;
	}

	protected function getLayoutData(): array
	{
		$data = parent::getLayoutData();
		$data['requestLink'] = $this->requestLink;

		return $data;
	}
}
