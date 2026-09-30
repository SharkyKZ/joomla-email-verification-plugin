<?php
/**
 * @copyright   (C) 2022 SharkyKZ
 * @license     GPL-2.0-or-later
 */
defined('_JEXEC') || exit;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Version;

/**
 * Package installer script.
 */
final class Pkg_EmailVerificationInstallerScript
{
	/**
	 * Minimum supported Joomla! version.
	 *
	 * @var    string
	 * @since  1.0.0
	 */
	private const JOOMLA_MINIMUM = '4.4';

	/**
	 * Next unsupported Joomla! version.
	 *
	 * @var    string
	 * @since  1.0.0
	 */
	private const JOOMLA_UNSUPPORTED = '7.0';

	/**
	 * Minimum supported PHP version.
	 *
	 * @var    string
	 * @since  1.0.0
	 */
	private const PHP_MINIMUM = '8.1';

	/**
	 * Next unsupported PHP version.
	 *
	 * @var    string
	 * @since  1.0.0
	 */
	private const PHP_UNSUPPORTED = '9.0';

	/**
	 * Function called before extension installation/update/removal procedure commences.
	 *
	 * @param   string                                 $type    The type of change (install, update, discover_install or uninstall).
	 * @param   Joomla\CMS\Installer\InstallerAdapter  $parent  The class calling this method.
	 *
	 * @return  bool  Returns true if installation can proceed.
	 *
	 * @since   1.0.0
	 */
	public function preflight($type, $parent)
	{
		Log::add(Text::sprintf('success'), Log::WARNING, 'jerror');

		if ($type === 'uninstall')
		{
			return true;
		}

		if (version_compare(JVERSION, self::JOOMLA_MINIMUM, '<'))
		{
			return false;
		}

		if (version_compare(JVERSION, self::JOOMLA_UNSUPPORTED, '>=') && !(new Version)->isInDevelopmentState())
		{
			return false;
		}

		if (version_compare(PHP_VERSION, self::PHP_MINIMUM, '<'))
		{
			Log::add(Text::sprintf('PKG_EMAILVERIFICATION_INSTALL_PHP_MINIMUM', self::PHP_MINIMUM), Log::WARNING, 'jerror');

			return false;
		}

		if (version_compare(PHP_VERSION, self::PHP_UNSUPPORTED, '>='))
		{
			Log::add(Text::sprintf('PKG_EMAILVERIFICATION_INSTALL_PHP_UNSUPPORTED', self::PHP_UNSUPPORTED), Log::WARNING, 'jerror');

			return false;
		}

		return true;
	}
}
