<?php
/**
 * @copyright   (C) 2022 SharkyKZ
 * @license     GPL-2.0-or-later
 */
namespace Sharky\Plugin\System\EmailVerification;

\defined('_JEXEC') || exit;

use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\CMS\Application\CMSWebApplicationInterface;
use Joomla\CMS\Event\Model\PrepareFormEvent;
use Joomla\CMS\Extension\PluginInterface;
use Joomla\Event\DispatcherInterface;

/**
 * Email verification plugin.
 *
 * @since  1.0.0
 */
final class Plugin implements PluginInterface
{
	/**
	 * Dispatcher instance.
	 *
	 * @var    DispatcherInterface
	 * @since  1.0.0
	 */
	private $dispatcher;

	/**
	 * Application instance.
	 *
	 * @var    CMSApplicationInterface|CMSWebApplicationInterface
	 * @since  1.0.0
	 */
	private $app;

	public function __construct(DispatcherInterface $dispatcher, CMSApplicationInterface $app)
	{
		$this->dispatcher = $dispatcher;
		$this->app = $app;
	}

	public function setDispatcher(DispatcherInterface $dispatcher)
	{
		$this->dispatcher = $dispatcher;

		return $this;
	}

	public function registerListeners()
	{
		if ($this->app instanceof CMSWebApplicationInterface)
		{
			$this->dispatcher->addListener('onAfterRoute', $this->onAfterRoute(...));
			$this->dispatcher->addListener('onContentPrepareForm', $this->onContentPrepareForm(...));
		}
	}

	private function onAfterRoute()
	{
		$input = $this->app->getinput();

		if ($this->app->getIdentity() && !$this->app->getIdentity()->guest)
		{
			return;
		}

		if ($input->get('option') !== 'com_users' || $input->get('view') !== 'registration')
		{
			return;
		}

		$session = $this->app->getSession();
		$language = $this->app->getLanguage();
		$router = $this->app->getRouter();

		if (!$session->has('com_emailverification.verified'))
		{
			$this->app->redirect($router->build('index.php?option=com_emailverification&view=request'));
		}

		if (!$session->get('com_emailverification.verified'))
		{
			$this->app->redirect($router->build('index.php?option=com_emailverification&view=request'));
		}
	}

	public function onContentPrepareForm(PrepareFormEvent $event)
	{

	}
}
