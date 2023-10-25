<?php

namespace Sharky\Component\EmailVerification\Administrator\Model\Site;

defined('_JEXEC') || exit;

use Joomla\CMS\MVC\Model\ListModelInterface;

class RequestModel implements ListModelInterface
{
	public function getItems(): array
    {
        $dir = JPATH_ADMINISTRATOR . '/components/com_mvcoverride/overrides';

        if (!is_dir($dir))
        {
            return [];
        }

        foreach (scandir($dir) as $file)
        {
            var_dump($file);
        }
    }
}
