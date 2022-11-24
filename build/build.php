<?php

require (dirname(__DIR__)) . '/build-script/script.php';

(
	new class(
		str_replace('\\', '/', dirname(__DIR__)),
		str_replace('\\', '/', __DIR__),
		'emailverification',
		'system',
		'joomla-email-verification-plugin',
		'SharkyKZ',
		'System - Email Verification',
		'Plugin for verifying email addresses before registration.',
		'(4\.|3\.([89]|10))',
		'5.3.10',
	) extends PluginBuildScript
	{
		public function build(): void
		{
			$plugin = $this->pluginDirectory . '/' . $this->pluginElement . '.php';
			$script = $this->mediaDirectory . '/js/script.js';

			$hash = substr(hash_file('sha1', $script, false), 0, 8);
			$code = file_get_contents($plugin);

			$pattern = '/(private\s+static\s+\$scriptHash\s+=\s+\')(.*)(\';)/';
			$code = preg_replace($pattern, '${1}' . $hash . '$3', $code);

			file_put_contents($plugin, $code);

			parent::build();
		}
	}
)->build();
