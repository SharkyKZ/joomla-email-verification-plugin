<?php

namespace Sharky\Component\EmailVerification\Administrator\View;

\defined('_JEXEC') || exit;

use Joomla\DI\Container;

final readonly class ViewFactory
{
	public function __construct(private Container $container)
	{
	}

	public function createView(string $app, string $name): ViewInterface
	{
		return $this->container->buildObject(__NAMESPACE__ . '\\' . ucfirst($app) . '\\' . $name . 'View');
	}
}
