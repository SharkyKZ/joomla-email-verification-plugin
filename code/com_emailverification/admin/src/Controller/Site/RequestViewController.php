<?php

namespace Sharky\Component\EmailVerification\Administrator\Controller\Site;

\defined('_JEXEC') || exit;

use Joomla\CMS\Application\CMSWebApplicationInterface;
use Joomla\Input\Input;
use Sharky\Component\EmailVerification\Administrator\Controller\ControllerInterface;
use Sharky\Component\EmailVerification\Administrator\MvcFactory;

final class RequestViewController implements ControllerInterface
{
	public function __construct(private MvcFactory $mvcFactory)
	{

	}

	public function execute(CMSWebApplicationInterface $app, Input $input): void
	{
		$view = $this->mvcFactory->createView('Request', $app->getName());
		$model = $this->mvcFactory->createModel('Request', $app->getName());
		$form = $model->getForm();
		$view
			->addData('form', $form)
			->addData('language', $app->getLanguage());
		$output = $view->render($app->getDocument());

		echo $output;
	}
}
