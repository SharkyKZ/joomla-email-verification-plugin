<?php

namespace Sharky\Component\EmailVerification\Administrator;

\defined('_JEXEC') || exit;

use Joomla\CMS\Application\CMSWebApplicationInterface;
use Joomla\CMS\Dispatcher\DispatcherInterface;
use Joomla\DI\Container;
use Joomla\Input\Input;
use Sharky\Component\EmailVerification\Administrator\Controller\ControllerInterface;

final class Dispatcher implements DispatcherInterface
{
	public function __construct(private CMSWebApplicationInterface $app, private Input $input, private Container $container)
	{
	}

	public function dispatch()
	{
		if (!$this->app->isClient('site'))
		{
			throw new \RuntimeException($this->app->getLanguage()->_('JLIB_APPLICATION_ERROR_COMPONENT_NOT_FOUND'), 404);
		}

		$this->app->getLanguage()->load('com_emailverification', \JPATH_ADMINISTRATOR);

		$task = $this->input->get->get('task');
		$view = $this->input->get->get('view');

		if ($task)
		{
			if ($controller = $this->createController($task))
			{
				return $controller->execute($this->app, $this->input);
			}

			throw new \RuntimeException('Controller class not found.');
		}

		if ($view)
		{
			if ($controller = $this->createController($view . 'View'))
			{
				return $controller->execute($this->app, $this->input);
			}

			throw new \RuntimeException('Controller class not found.');
		}

		throw new \RuntimeException('Controller class not found.');
	}

	private function createController(string $name): ?ControllerInterface
	{
		$controller = $this->container->buildObject(__NAMESPACE__ . '\\Controller\\Site\\' . $name . 'Controller');

		if ($controller === false)
		{
			return null;
		}

		return $controller;
	}
}
