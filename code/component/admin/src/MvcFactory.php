<?php

namespace Sharky\Component\EmailVerification\Administrator;

\defined('_JEXEC') || exit;

use Joomla\DI\Container;

final class MvcFactory
{
    public function __construct(private string $namespace, private Container $container) {}

    public function createModel(string $name, string $app)
    {
        return $this->container->buildObject($this->getClassName('Model', $name, $app));
    }

    public function createController(string $name, string $app)
    {
        return $this->container->buildObject($this->getClassName('Controller', $name, $app));
    }

    public function createView(string $name, string $app)
    {
        return $this->container->buildObject($this->getClassName('View', $name, $app));
    }

    private function getClassName(string $type, string $name, string $app): string
    {
        return $this->namespace . '\\' . $type . '\\' . ucfirst($app) . '\\' . ucfirst($name) . $type;
    }
}
