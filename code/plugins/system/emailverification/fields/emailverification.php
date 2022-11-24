<?php
/**
 * @copyright   (C) 2022 SharkyKZ
 * @license     GPL-2.0-or-later
 */
defined('_JEXEC') || exit;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Router\Route;

FormHelper::loadFieldClass('text');

/**
 * Email Verification Code Field
 */
class JFormFieldEmailVerification extends JFormFieldText
{
	/**
     * Name of the layout being used to render the field
     *
     * @var    string
     * @since  1.0.0
     */
    protected $buttonLayout = 'field.emailverification';

	/**
     * Gets the layout paths
     *
     * @return  array
     *
     * @since   1.0.0
     */
    protected function getLayoutPaths()
    {
        $template = Factory::getApplication()->getTemplate();

        return array(
            JPATH_SITE . '/templates/' . $template . '/html/layouts/plugins/system/emailverification',
            JPATH_SITE . '/templates/' . $template . '/html/layouts',
            JPATH_PLUGINS . '/system/emailverification/layouts',
            JPATH_SITE . '/layouts',
        );
    }

	/**
     * Method to get the field input markup.
     *
     * @return  string  The field input markup.
     *
     * @since   1.0.0
     */
	protected function getInput()
	{
		$app = Factory::getApplication();

		$app->getDocument()->addScriptOptions(
			'plg_system_emailverification',
			array(
				'url' => Route::_('index.php?option=com_ajax&plugin=emailVerification&group=system&format=json', false, false, Route::TLS_IGNORE, true),
			)
		);

		$data = array(
			'messageId' => $this->id . '-message',
			'buttonId' => $this->id . '-button',
			'app' => $app,
		);

		return $this->getRenderer($this->buttonLayout)->render($data) . parent::getInput();
	}
}
