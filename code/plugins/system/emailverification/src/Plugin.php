<?php
/**
 * @copyright   (C) 2022 SharkyKZ
 * @license     GPL-2.0-or-later
 */
namespace Sharky\Plugin\System\EmailVerification;

\defined('_JEXEC') || exit;

use Joomla\CMS\Application\CMSApplicationInterface;
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
	 * @var    CMSApplicationInterface
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
		$this->dispatcher->addListener('onAfterRoute', $this->redirect(...));
	}

	private function redirect()
	{
		$input = $this->app->getinput();

		if ($input->get('option') === 'com_users' && $input->get('view') === 'registration')
		{
			if (!$this->validate())
			{
				$this->app->redirect('index.php?option=com_emailverification&view=request');
			}
		}
	}
}
