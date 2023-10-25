<?php
/**
 * @copyright   (C) 2021 SharkyKZ
 * @license     GPL-2.0-or-later
 */

defined('_JEXEC') || exit;

use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\CMS\Dispatcher\ComponentDispatcherFactoryInterface;
use Joomla\CMS\Dispatcher\DispatcherInterface;
use Sharky\Component\EmailVerification\Administrator\Component;
use Joomla\CMS\Extension\ComponentInterface;
use Joomla\CMS\Factory;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Input\Input;
use Sharky\Component\EmailVerification\Administrator\Dispatcher;
use Sharky\Component\EmailVerification\Administrator\MvcFactory;
use Sharky\Component\EmailVerification\Administrator\Renderer\GenericRenderer;
use Sharky\Component\EmailVerification\Administrator\Renderer\RendererInterface;

return new class implements ServiceProviderInterface
{
	public function register(Container $container)
	{
		$container->share(
			ComponentInterface::class,
			static fn (Container $container) => new Component(
                new class ($container) implements ComponentDispatcherFactoryInterface
                {
                    public function __construct(private Container $container)
                    {
                    }

                    public function createDispatcher(CMSApplicationInterface $application, ?Input $input = null): DispatcherInterface
                    {
                        return new Dispatcher(
                            $application,
                            $input ?? $application->getInput(),
                            $this->container->get(MvcFactory::class)
                        );
                    }
                }
            )
		);
        $container->share(
            MvcFactory::class,
            static fn (Container $container) => new MvcFactory('Sharky\\Component\\EmailVerification\\Administrator', $container)
        );

        $container->share(
            RendererInterface::class,
            static function (Container $container)
            {
                $renderer = new GenericRenderer;
                $renderer->prependPath(\JPATH_ADMINISTRATOR . '/components/com_emailverification/layouts');
                $renderer->prependPath(\JPATH_ADMINISTRATOR . '/templates/' . Factory::getApplication()->getTemplate(true)->template . '/layouts/com_emailverification');

                return $renderer;
            }
        );
	}
};
