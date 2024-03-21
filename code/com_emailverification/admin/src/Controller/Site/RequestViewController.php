<?php

namespace Sharky\Component\EmailVerification\Administrator\Controller\Site;

\defined('_JEXEC') || exit;

use Joomla\CMS\Application\CMSWebApplicationInterface;
use Joomla\Input\Input;
use Sharky\Component\EmailVerification\Administrator\Controller\ControllerInterface;
use Sharky\Component\EmailVerification\Administrator\Model\Site\RequestModel;
use Sharky\Component\EmailVerification\Administrator\View\Site\RequestView;

final class RequestViewController implements ControllerInterface
{
	public function __construct(private RequestModel $model, private RequestView $view)
	{
	}

	public function execute(CMSWebApplicationInterface $app, Input $input): void
	{
		$form = $this->model->getForm();
		$this->view
			->addData('form', $form)
			->addData('language', $app->getLanguage());
		$output = $this->view->render($app->getDocument());

		echo $output;
	}
}
