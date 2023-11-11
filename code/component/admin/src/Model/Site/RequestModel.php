<?php

namespace Sharky\Component\EmailVerification\Administrator\Model\Site;

\defined('_JEXEC') || exit;

use Joomla\CMS\Form\Form;
use Joomla\CMS\Language\Language;
use Joomla\CMS\Mail\Mail;
use Joomla\CMS\Router\Router;
use Joomla\CMS\Uri\Uri;
use Joomla\Registry\Registry;

final class RequestModel
{
	public function __construct(private Mail $mailer)
	{
	}

	public function getForm(): Form
	{
		$form = new Form('com_emailverification.request', ['control' => 'jform']);
		$form->loadFile(\JPATH_ADMINISTRATOR . '/components/com_emailverification/forms/request.xml');

		return $form;
	}

	public function generateCode(): string
	{
		return str_pad((string) random_int(1000, 999999), 6, '0', \STR_PAD_LEFT);
	}

	public function createRequest(string $code, string $email, Registry $config, Language $language, Router $router): bool
	{
		$verifyUrl = $router->build('index.php?option=com_emailverification&task=verify&code=' . $code);
		$this->mailer->setSubject($language->_('COM_EMAILVERIFICATION_REQUEST_SUBJECT'));
		$this->mailer->setBody(sprintf('COM_EMAILVERIFICATION_REQUEST_BODY', $config->get('sitename', Uri::root()), $code));
		$this->mailer->addRecipient($email);
	}
}
