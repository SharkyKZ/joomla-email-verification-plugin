<?php

namespace Sharky\Component\EmailVerification\Administrator\Model\Site;

\defined('_JEXEC') || exit;

use Joomla\CMS\Form\Form;

final class VerifyModel
{
	public function getForm(): Form
	{
		$form = new Form('com_emailverification.verify', ['control' => 'jform']);
		$form->loadFile(\JPATH_ADMINISTRATOR . '/components/com_emailverification/forms/verify.xml');

		return $form;
	}
}
