<?php

namespace Sharky\Component\EmailVerification\Administrator\Controller\Site;

\defined('_JEXEC') || exit;

use Joomla\CMS\Application\CMSWebApplicationInterface;
use Joomla\CMS\Router\SiteRouter;
use Joomla\Input\Input;
use Sharky\Component\EmailVerification\Administrator\Controller\ControllerInterface;
use Sharky\Component\EmailVerification\Administrator\MvcFactory;

final class VerifyController implements ControllerInterface
{
	public function __construct(private MvcFactory $mvcFactory, private SiteRouter $router)
	{
	}

	public function execute(CMSWebApplicationInterface $app, Input $input): void
	{
		$language = $app->getLanguage();
		/** @var \Sharky\Component\EmailVerification\Administrator\Model\Site\VerifyModel */
		$model = $this->mvcFactory->createModel('Verify', $app->getName());
		$form = $model->getForm();
		$data = $form->process($input->get('jform', [], 'ARRAY'));

		if ($data === false)
		{
			foreach ($form->getErrors() as $error)
			{
				$app->enqueueMessage($language->_($error));
			}

			$app->redirect($this->router->build('index.php?option=com_emailverification&view=request'));
		}

		/** @var \Sharky\Component\EmailVerification\Administrator\Model\Site\RequestModel */
		$model = $this->mvcFactory->createModel('Request', $app->getName());

		try
		{
			$result = $model->verifyRequest($data['code'], $app->getLanguage(), $this->router);
		}
		catch (\Exception $e)
		{
			$app->enqueueMessage($e->getMessage());
			$app->redirect($this->router->build('index.php?option=com_emailverification&view=request'));
		}

		$app->getSession()->set('com_emailverification', ['email' => $result->email, 'verified' => true]);
		$app->enqueueMessage($language->_('COM_EMAILVERIFICATION_EMAIL_VERIFIED'));
		$app->redirect($this->router->build('index.php?option=com_users&view=registration'));
	}
}
