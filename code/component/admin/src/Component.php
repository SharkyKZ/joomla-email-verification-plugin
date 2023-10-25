<?php

namespace Sharky\Component\EmailVerification\Administrator;

\defined('_JEXEC') || exit;

use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\CMS\Dispatcher\ComponentDispatcherFactoryInterface;
use Joomla\CMS\Dispatcher\DispatcherInterface;
use Joomla\CMS\Extension\ComponentInterface;

final class Component implements ComponentInterface
{
    public function __construct(private ComponentDispatcherFactoryInterface $dispatcherFactory)
    {
    }

	public function getDispatcher(CMSApplicationInterface $application): DispatcherInterface
	{
        return $this->dispatcherFactory->createDispatcher($application, $application->getInput());
	}
}
