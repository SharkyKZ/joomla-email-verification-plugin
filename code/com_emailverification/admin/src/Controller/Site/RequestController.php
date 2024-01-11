<?php

namespace Sharky\Component\EmailVerification\Administrator\Controller\Site;

\defined('_JEXEC') || exit;

use Joomla\CMS\Application\CMSWebApplicationInterface;
use Joomla\CMS\Router\SiteRouter;
use Joomla\Input\Input;
use Sharky\Component\EmailVerification\Administrator\Controller\ControllerInterface;
use Sharky\Component\EmailVerification\Administrator\MvcFactory;

final class RequestController implements ControllerInterface
{
	public function __construct(private MvcFactory $mvcFactory, private SiteRouter $router)
	{
	}

	public function execute(CMSWebApplicationInterface $app, Input $input): void
	{
		$language = $app->getLanguage();
		$model = $this->mvcFactory->createModel('Request', $app->getName());
		$form = $model->getForm();

		if (!$form->validate($input->get('jform', [], 'ARRAY')))
		{
			foreach ($form->getErrors() as $error)
			{
				$app->enqueueMessage($language->_($error));
			}

			$app->redirect('index.php?option=com_emailverification&view=request');
		}

		$app->enqueueMessage($language->_('COM_EMAILVERIFICATION_REQUEST_CREATED'));
		$app->redirect('index.php?option=com_emailverification&view=verify');
	}
}
