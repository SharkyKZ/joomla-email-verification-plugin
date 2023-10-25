<?php

namespace Sharky\Component\EmailVerification\Administrator\View\Site;

\defined('_JEXEC') || exit;

use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Document\Document;
use Joomla\CMS\Layout\FileLayout;
use Sharky\Component\EmailVerification\Administrator\AbstractView;

class RequestView extends AbstractView
{
	public function render(Document $document): string
    {
        return $this->renderer->render('request/default', $this->getData());
    }
}
