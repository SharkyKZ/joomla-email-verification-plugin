<?php
/**
 * @copyright   (C) 2022 SharkyKZ
 * @license     GPL-2.0-or-later
 */
namespace Sharky\Plugin\System\EmailVerification;

\defined('_JEXEC') || exit;

use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\CMS\Application\CMSWebApplicationInterface;
use Joomla\CMS\Event\Application\AfterRouteEvent;
use Joomla\CMS\Event\Model\BeforeValidateDataEvent;
use Joomla\CMS\Event\Model\PrepareFormEvent;
use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Router\SiteRouter;
use Joomla\Event\DispatcherInterface;

/**
 * Email verification plugin.
 *
 * @since  1.0.0
 */
final class Plugin implements PluginInterface
{
	public function __construct(
		private DispatcherInterface $dispatcher,
		private CMSApplicationInterface $app,
		private SiteRouter $router
	)
	{
	}

	public function setDispatcher(DispatcherInterface $dispatcher)
	{
		$this->dispatcher = $dispatcher;

		return $this;
	}

	public function registerListeners(): void
	{
		$this->dispatcher->addListener('onAfterRoute', $this->onAfterRoute(...));
		$this->dispatcher->addListener('onContentPrepareForm', $this->onContentPrepareForm(...));
		$this->dispatcher->addListener('onContentBeforeValidateData', $this->onContentBeforeValidateData(...));
	}

	private function onAfterRoute(AfterRouteEvent $event): void
	{
		$app = $event->getApplication();

		if (!$app instanceof CMSWebApplicationInterface)
		{
			return;
		}

		if ($app->getIdentity() && !$app->getIdentity()->guest)
		{
			return;
		}

		$input = $app->getinput();

		if ($input->get('option') !== 'com_users' || $input->get('view') !== 'registration')
		{
			return;
		}

		$session = $app->getSession();

		if (!$session->has('com_emailverification.verified'))
		{
			$app->redirect($this->router->build('index.php?option=com_emailverification&view=request'));
		}

		if (!$session->get('com_emailverification.verified'))
		{
			$app->redirect($this->router->build('index.php?option=com_emailverification&view=request'));
		}
	}

	private function onContentBeforeValidateData(BeforeValidateDataEvent $event): void
	{
		if (!$this->app instanceof CMSWebApplicationInterface)
		{
			return;
		}

		if ($event->getForm()->getName() !== 'com_users.registration')
		{
			return;
		}

		$data = (object) $event->getData();
		$email = $data->email1 ?? '';
		$session = $this->app->getSession();

		if ($email === '' || !$session->has('com_emailverification.email') || $session->get('com_emailverification.email') !== $email)
		{
			$this->app->redirect($this->router->build('index.php?option=com_emailverification&view=request'));
		}
	}

	private function onContentPrepareForm(PrepareFormEvent $event): void
	{
		$this->app->getLanguage()->load('com_emailverification', \JPATH_ADMINISTRATOR);

		$form = $event->getForm();

		if ($form->getName() !== 'com_users.registration')
		{
			return;
		}

		$session = $this->app->getSession();
		FormHelper::addFieldPrefix('Sharky\Plugin\System\EmailVerification\Field');
		$form->setFieldAttribute('email1', 'requestLink', (string) $this->router->build('index.php?option=com_emailverification&view=request'));
		$form->setFieldAttribute('email1', 'readonly', true);
		$form->setValue('email1', null, $session->get('com_emailverification.email'));
	}
}
