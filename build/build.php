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
		'5\.|4\.',
		'7.2.5',
	)
)->build();
