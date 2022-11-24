<?php
/**
 * @copyright   (C) 2022 SharkyKZ
 * @license     GPL-2.0-or-later
 */

defined('_JEXEC') || exit;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Uri\Uri;

/**
 * Email verification plugin.
 *
 * @since  1.0.0
 */
final class PlgSystemEmailVerification extends CMSPlugin
{
	/**
	 * Application instance.
	 *
	 * @var    \Joomla\CMS\Application\CMSApplicationInterface
	 * @since  1.0.0
	 */
	protected $app;

	/**
	 * Prepares form.
	 *
	 * @param   Form   $form  The form to be altered.
	 * @param   mixed  $data  The associated data for the form.
	 *
	 * @return  void
	 *
	 * @since	1.0.0
	 */
	public function onContentPrepareForm(Form $form, $data)
	{
		if ($form->getName() !== 'com_users.registration')
		{
			return;
		}

		$this->loadLanguage();

		$form->load(
			'<form>
				<fieldset addfieldpath="plugins/system/emailverification/fields" addrulepath="plugins/system/emailverification/rules" name="emailVerification" label="PLG_SYSTEM_EMAILVERIFICATION_FIELDSET_LEGEND">
					<field type="emailverification" name="emailVerification" required="true" validate="emailverification" label="PLG_SYSTEM_EMAILVERIFICATION_FIELD_LABEL" description="PLG_SYSTEM_EMAILVERIFICATION_FIELD_DESCRIPTION" />
				</fieldset>
			</form>'
		);
	}

	/**
	 * Sends verification email.
	 *
	 * @return  array
	 *
	 * @since	1.0.0
	 * @throws  Throwable
	 */
	public function onAjaxEmailVerification()
	{
		$this->app->allowCache(false);

		$this->loadLanguage();
		$language = $this->app->getLanguage();

		$email = $this->app->input->get('email', null, 'RAW');
		$mailer = Factory::getMailer();

		if (empty($email) || !is_string($email) || !$mailer::validateAddress($email, 'html5'))
		{
			throw new RuntimeException($language->_('PLG_SYSTEM_EMAILVERIFICATION_EMAIL_INVALID'));
		}

		$code = str_pad((string) random_int(1000, 999999), 6, '0', STR_PAD_LEFT);
		$this->app->setUserState('plg_system_emailverification.email', $email);
		$this->app->setUserState('plg_system_emailverification.code', $code);

		$mailer->addRecipient($email);
		$mailer->setSubject($language->_('PLG_SYSTEM_EMAILVERIFICATION_EMAIL_SUBJECT'));
		$mailer->setBody(sprintf($language->_('PLG_SYSTEM_EMAILVERIFICATION_EMAIL_BODY'), Uri::root(), $code));
		$result = $mailer->Send();

		if ($result !== true)
		{
			// On J3 an exception can be returned.
			if (($result instanceof Throwable) || ($result instanceof Exception))
			{
				throw $result;
			}

			return array('success' => false, 'message' => $language->_('PLG_SYSTEM_EMAILVERIFICATION_EMAIL_ERROR'));
		}

		return array('success' => true, 'message' => $language->_('PLG_SYSTEM_EMAILVERIFICATION_EMAIL_SENT'));
	}
}
