<?php
/**
 * @copyright   (C) 2022 SharkyKZ
 * @license     GPL-2.0-or-later
 */
defined('_JEXEC') || exit;

use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Installer\InstallerScriptInterface;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Version;

/**
 * Package installer script.
 */
final class Pkg_EmailVerificationInstallerScript implements InstallerScriptInterface
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

	public function preflight(string $type, InstallerAdapter $parent): bool
	{
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

	public function install(InstallerAdapter $adapter): true
	{
		return true;
	}

	public function update(InstallerAdapter $adapter): true
	{
		return true;
	}

	public function postflight(string $type, InstallerAdapter $adapter): true
	{
		return true;
	}

	public function uninstall(InstallerAdapter $adapter): true
	{
		return true;
	}
}
