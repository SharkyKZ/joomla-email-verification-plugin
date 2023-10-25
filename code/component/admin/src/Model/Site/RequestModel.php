<?php

namespace Sharky\Component\EmailVerification\Administrator\Model\Site;

\defined('_JEXEC') || exit;

use Joomla\CMS\Form\Form;

final class RequestModel
{
	public function getForm(): Form
    {
        $form = new Form('com_emailverification.request', ['control' => 'jform']);
        $form->loadFile(\JPATH_ADMINISTRATOR . '/components/com_emailverification/forms/request.xml');

        return $form;
    }
}
