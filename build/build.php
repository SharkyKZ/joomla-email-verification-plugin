<?php

require (dirname(__DIR__)) . '/build-script/script.php';

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
