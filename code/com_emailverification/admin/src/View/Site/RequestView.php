<?php

namespace Sharky\Component\EmailVerification\Administrator\View\Site;

\defined('_JEXEC') || exit;

use Joomla\CMS\Document\Document;
use Joomla\CMS\Router\SiteRouter;
use Sharky\Component\EmailVerification\Administrator\Renderer\RendererInterface;
use Sharky\Component\EmailVerification\Administrator\View\AbstractView as AbstractView;

final class RequestView extends AbstractView
{
	public function __construct(RendererInterface $renderer, SiteRouter $router)
	{
		$this->addData('router', $router);

		parent::__construct($renderer);
	}

	public function render(Document $document): string
	{
		return $this->renderer->render('request/default', $this->getData());
	}
}
