<?php

require (dirname(__DIR__)) . '/build-script/script.php';

$plugin = dirname(__DIR__) . '/code/plugins/system/emailverification/emailverification.php';
$script = dirname(__DIR__) . '/code/media/plg_system_emailverification/js/script.js';

$hash = substr(hash_file('sha1', $script, false), 0, 8);
$code = file_get_contents($plugin);

$pattern = '/(private\s+static\s+\$scriptHash\s+=\s+\')(.*)(\';)/';
$code = preg_replace($pattern, '${1}' . $hash . '$3', $code);

file_put_contents($plugin, $code);

(
	new PluginBuildScript(
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
	)
)->build();
