<?php

namespace Sharky\Component\EmailVerification\Administrator\Model\Site;

\defined('_JEXEC') || exit;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Language\Language;
use Joomla\CMS\Mail\Mail;
use Joomla\CMS\Router\Router;
use Joomla\CMS\Uri\Uri;
use Joomla\Database\DatabaseDriver;
use Joomla\Registry\Registry;
use RuntimeException;

final class RequestModel
{
	public function __construct(private DatabaseDriver $db, private Mail $mailer)
	{
	}

	public function getForm(): Form
	{
		$form = new Form('com_emailverification.request', ['control' => 'jform']);
		$form->loadFile(\JPATH_ADMINISTRATOR . '/components/com_emailverification/forms/request.xml');

		return $form;
	}

	/**
	 * @throws \Exception
	 */
	public function createRequest(string $email, string $sitename, Language $language, Router $router): void
	{
		$code = $this->generateToken();

		if (!$this->addRequest($code, $email))
		{
			throw new \RuntimeException($language->_('COM_EMAILVERIFICATION_REQUEST_CREATING_FAILED'));
		}

		$verifyUrl = $router->build('index.php?option=com_emailverification&task=verify&code=' . $code);
		$this->mailer->setSubject($language->_('COM_EMAILVERIFICATION_REQUEST_SUBJECT'));
		$this->mailer->setBody(sprintf($language->_('COM_EMAILVERIFICATION_REQUEST_BODY'), $sitename, Uri::root(), $code));
		$this->mailer->addRecipient($email);

		if (!$this->mailer->Send())
		{
			throw new \RuntimeException($language->_('COM_EMAILVERIFICATION_REQUEST_SENDING_FAILED'));
		}
	}

	public function verifyRequest(string $token, Language $language): \stdClass
	{
		$values = [$token];
		$query = $this->db->createQuery();
		$query->select('*')
			->from('#__emailverification_requests')
			->where(['token = :token'])
			->setLimit(1)
			->bind([':token'], $values);

		$result = $this->db->setQuery($query)->loadObject();

		if (!$result)
		{
			throw new \RuntimeException($language->_('COM_EMAILVERIFICATION_REQUEST_NOT_FOUND'));
		}

		if ($result->expirationDate < Factory::getDate())
		{
			throw new \RuntimeException($language->_('COM_EMAILVERIFICATION_REQUEST_EXPIRED'));
		}

		$this->deleteRequests($result->email, null);

		return $result;
	}

	private function generateToken(): string
	{
		return str_pad((string) random_int(1000, 999999), 6, '0', \STR_PAD_LEFT);
	}

	private function addRequest($token, $email): bool
	{
		// Delete old requests.
		$this->deleteRequests($email, null);

		$values = [$token, $email, Factory::getDate('+1 hour')->toSql(false, $this->db)];
		$query = $this->db->createQuery();
		$query->insert('#__emailverification_requests')
			->columns(['token', 'email', 'expirationDate'])
			->values([':token, :email, :expiration'])
			->bind(
				[':token', ':email', ':expiration'],
				$values
			);

		try
		{
			$this->db->setQuery($query)->execute();
		}
		catch (\RuntimeException)
		{
			return false;
		}

		return true;
	}

	private function deleteRequests(?string $email, ?string $token): int
	{
		if ($email === null && $token === null)
		{
			return 0;
		}

		$query = $this->db->createQuery();
		$query->delete('#__emailverification_requests');

		if ($email !== null)
		{
			$query->where('email = :email')
				->bind(':email', $email);
		}

		if ($token !== null)
		{
			$query->where('token = :token')
				->bind(':token', $email);
		}

		try
		{
			$this->db->setQuery($query)->execute();
		}
		catch (\RuntimeException)
		{
			return 0;
		}

		return $this->db->getAffectedRows();
	}
}
