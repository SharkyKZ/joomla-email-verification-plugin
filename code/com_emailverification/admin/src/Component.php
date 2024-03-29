<?php

namespace Sharky\Component\EmailVerification\Administrator;

\defined('_JEXEC') || exit;

use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\CMS\Dispatcher\DispatcherInterface;
use Joomla\CMS\Extension\ComponentInterface;
use Joomla\DI\Container;

final class Component implements ComponentInterface
{
	public function __construct(private Container $container)
	{
	}

	public function getDispatcher(CMSApplicationInterface $application): DispatcherInterface
	{
		return new Dispatcher($application, $application->getInput(), $this->container);
	}
}
