<?php

namespace Sharky\Component\EmailVerification\Administrator\Controller;

\defined('_JEXEC') || exit;

use Joomla\CMS\Application\CMSWebApplicationInterface;
use Joomla\Input\Input;

interface ControllerInterface
{
	public function execute(CMSWebApplicationInterface $app, Input $input): void;
}