<?php

namespace Sharky\Component\EmailVerification\Administrator;

\defined('_JEXEC') || exit;

use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\CMS\Component\Router\RouterInterface;
use Joomla\CMS\Component\Router\RouterServiceInterface;
use Joomla\CMS\Dispatcher\DispatcherInterface;
use Joomla\CMS\Extension\ComponentInterface;
use Joomla\CMS\Menu\AbstractMenu;
use Joomla\DI\Container;

final class Component implements ComponentInterface, RouterServiceInterface
{
	public function __construct(private Container $container)
	{
	}

	public function getDispatcher(CMSApplicationInterface $application): DispatcherInterface
	{
		return new Dispatcher($application, $application->getInput(), $this->container);
	}

	public function createRouter(CMSApplicationInterface $application, AbstractMenu $menu): RouterInterface
	{
		return new Router($application, $menu);
	}
}
