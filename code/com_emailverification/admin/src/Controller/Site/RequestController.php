<?php

namespace Sharky\Component\EmailVerification\Administrator\Controller\Site;

\defined('_JEXEC') || exit;

use Joomla\CMS\Application\CMSWebApplicationInterface;
use Joomla\CMS\Router\SiteRouter;
use Joomla\Input\Input;
use Sharky\Component\EmailVerification\Administrator\Controller\ControllerInterface;
use Sharky\Component\EmailVerification\Administrator\Model\Site\RequestModel;

final class RequestController implements ControllerInterface
{
	public function __construct(private RequestModel $model, private SiteRouter $router)
	{
	}

	public function execute(CMSWebApplicationInterface $app, Input $input): void
	{
		$language = $app->getLanguage();
		$form = $this->model->getForm();
		$data = $form->process($input->get('jform', [], 'ARRAY'));

		if ($data === false)
		{
			foreach ($form->getErrors() as $error)
			{
				$app->enqueueMessage($language->_($error));
			}

			$app->redirect($this->router->build('index.php?option=com_emailverification&view=request'));
		}

		try
		{
			$this->model->createRequest($data['email'], $app->get('sitename', ''), $app->getLanguage(), $this->router);
		}
		catch (\Exception $e)
		{
			$app->enqueueMessage($e->getMessage());
			$app->redirect($this->router->build('index.php?option=com_emailverification&view=request'));
		}

		$session = $app->getSession();
		$session->set('com_emailverification.verified', false);
		$session->set('com_emailverification.email', $data['email']);

		$app->enqueueMessage($language->_('COM_EMAILVERIFICATION_REQUEST_CREATED'));
		$app->redirect($this->router->build('index.php?option=com_emailverification&view=verify'));
	}
}
