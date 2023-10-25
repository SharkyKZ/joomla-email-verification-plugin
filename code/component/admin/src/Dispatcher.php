<?php

namespace Sharky\Component\EmailVerification\Administrator;

\defined('_JEXEC') || exit;

use Joomla\CMS\Application\CMSWebApplicationInterface;
use Joomla\CMS\Dispatcher\Dispatcher as CoreDispatcher;
use Joomla\Input\Input;

final class Dispatcher extends CoreDispatcher
{
    public function __construct(CMSWebApplicationInterface $app, Input $input, private MvcFactory $mvcFactory)
    {
        parent::__construct($app, $input);
    }

	public function dispatch()
    {
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
