<?php
/**
 * @copyright   (C) 2021 SharkyKZ
 * @license     GPL-2.0-or-later
 */

defined('_JEXEC') || exit;

use Joomla\CMS\Application\ApplicationHelper;
use Joomla\CMS\Application\CMSApplication;
use Sharky\Component\EmailVerification\Administrator\Component;
use Joomla\CMS\Extension\ComponentInterface;
use Joomla\CMS\Factory;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;;
use Sharky\Component\EmailVerification\Administrator\Renderer\GenericRenderer;
use Sharky\Component\EmailVerification\Administrator\Renderer\RendererInterface;

return new class implements ServiceProviderInterface
{
	public function register(Container $container)
	{
		$container->share(Container::class, $container);

		$container->share(
			ComponentInterface::class,
			static fn (Container $container) => new Component($container)
		);

		$container->share(
			RendererInterface::class,
			static function ()
			{
				$renderer = new GenericRenderer;
				$renderer->prependPath(\JPATH_ADMINISTRATOR . '/components/com_emailverification/layouts');
				$app = Factory::getApplication();

				if ($app instanceof CMSApplication)
				{
					$appInfo = ApplicationHelper::getClientInfo($app->getName(), true);

					$renderer->prependPath(
						$appInfo->path . '/templates/' . $app->getTemplate(true)->template . '/layouts/com_emailverification'
					);
				}

				return $renderer;
			}
		);
	}
};
