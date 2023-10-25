<?php

namespace Sharky\Component\EmailVerification\Administrator\View\Site;

\defined('_JEXEC') || exit;

use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Document\Document;
use Joomla\CMS\Layout\FileLayout;
use Sharky\Component\EmailVerification\Administrator\ViewInterface;

class RequestView implements ViewInterface
{
	public function __construct(protected SiteApplication $app)
	{

	}

	public function render(Document $document): string
    {
        $layout = new FileLayout('request.default');
        $layout->addIncludePath(\JPATH_ADMINISTRATOR . '/components/com_emailverification/layouts');
        $layout->addIncludePath(\JPATH_ADMINISTRATOR . '/templates/' . $this->app->getTemplate(true)->template . '/layouts/com_emailverification');

        return $layout->render();
    }
}
