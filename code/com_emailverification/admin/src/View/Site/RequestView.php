<?php

namespace Sharky\Component\EmailVerification\Administrator\View\Site;

\defined('_JEXEC') || exit;

use Joomla\CMS\Document\Document;
use Sharky\Component\EmailVerification\Administrator\View\AbstractView as AbstractView;

final class RequestView extends AbstractView
{
	public function render(Document $document): string
	{
		return $this->renderer->render('request/default', $this->getData());
	}
}
