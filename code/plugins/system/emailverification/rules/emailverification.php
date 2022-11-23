<?php
/**
 * @copyright   (C) 2022 SharkyKZ
 * @license     GPL-2.0-or-later
 */
defined('_JEXEC') || exit;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\FormRule;
use Joomla\Registry\Registry;

class JFormRuleEmailVerification extends FormRule
{
	/**
	 * Method to test if two fields have a value in order to use only one field.
	 * To use this rule, the form
	 * XML needs a validate attribute of loginuniquefield and a field attribute
	 * that is equal to the field to test against.
	 *
	 * @param   SimpleXMLElement  $element  The SimpleXMLElement object representing the `<field>` tag for the form field object.
	 * @param   mixed             $value    The form field value to validate.
	 * @param   string            $group    The field name group control value. This acts as an array container for the field.
	 *                                      For example if the field has name="foo" and the group value is set to "bar" then the
	 *                                      full field name would end up being "bar[foo]".
	 * @param   Registry          $input    An optional Registry object with the entire data set to validate against the entire form.
	 * @param   Form              $form     The form object for which the field is being tested.
	 *
	 * @return  bool|\UnexpectedValueException  True if the value is valid, exception otherwise.
	 *
	 * @since   1.0.0
	 */
	public function test(SimpleXMLElement $element, $value, $group = null, Registry $input = null, Form $form = null)
	{
		$app = Factory::getApplication();
		$code = $app->getUserState('plg_system_emailverification.code');
		$app->setUserState('plg_system_emailverification.code', null);

		if ($value !== $code)
		{
			return new \UnexpectedValueException($app->getLanguage()->_('PLG_SYSTEM_EMAILVERIFICATION_CODE_INVALID'));
		}

		return true;
	}
}
