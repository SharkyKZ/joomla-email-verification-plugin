<?php
/**
 * @copyright   (C) 2022 SharkyKZ
 * @license     GPL-2.0-or-later
 */
defined('_JEXEC') || exit;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormHelper;

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

	protected function getLayoutData()
	{
		$data = parent::getLayoutData();
		$id = isset($data['id']) ? $data['id'] : $this->id;
		$data['messageId'] = $id . '-message';
		$data['buttonId'] = $id . '-button';
		$data['app'] = Factory::getApplication();

		return $data;
	}

	protected function getInput()
	{
		$html = '<div>' . $this->getRenderer($this->buttonLayout)->render($this->getLayoutData()) . '</div><br>';

		return $html . '<div>' . parent::getInput() . '</div>';
	}
}
