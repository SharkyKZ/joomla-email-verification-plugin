<?php

namespace Sharky\Component\EmailVerification\Administrator;

\defined('_JEXEC') || exit;

use Joomla\CMS\Application\CMSWebApplicationInterface;
use Joomla\CMS\Component\Exception\MissingComponentException;
use Joomla\CMS\Dispatcher\DispatcherInterface;
use Joomla\Input\Input;

final class Dispatcher implements DispatcherInterface
{
	public function __construct(private CMSWebApplicationInterface $app, private Input $input, private MvcFactory $mvcFactory)
	{
	}

	public function dispatch()
	{
		if (!$this->app->isClient('site'))
		{
			throw new \RuntimeException($this->app->getLanguage()->_('JLIB_APPLICATION_ERROR_COMPONENT_NOT_FOUND'));
		}

		$this->app->getLanguage()->load('com_emailverification', \JPATH_ADMINISTRATOR);

		$task = $this->input->get->get('task');
		$view = $this->input->get->get('view');

		if ($task)
		{
			if ($controller = $this->mvcFactory->createController($task, $this->app->getName()))
			{
				return $controller->execute($this->app, $this->input);
			}

			throw new \RuntimeException('Controller class not found.');
		}

		if ($view)
		{
			if ($controller = $this->mvcFactory->createController($view . 'View', $this->app->getName()))
			{
				return $controller->execute($this->app, $this->input);
			}

			throw new \RuntimeException('Controller class not found.');
		}

		throw new \RuntimeException('Controller class not found.');
	}
}
