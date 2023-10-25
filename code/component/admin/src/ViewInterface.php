<?php

namespace Sharky\Component\EmailVerification\Administrator;

defined('_JEXEC') || exit;

use Joomla\CMS\Document\Document;

interface ViewInterface
{
	public function render(Document $document): string;
}
