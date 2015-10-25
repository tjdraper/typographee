<?php

defined('TYPOGRAPHEE_VER') || define('TYPOGRAPHEE_VER', '2.0.0');

return array(
	'author' => 'TJ Draper',
	'author_url' => 'https://buzzingpixel.com',
	'description' => 'Parse content through EE typography class',
	'docs_url' => 'https://buzzingpixel.com/ee-add-ons/typographee/documentation',
	'name' => 'Typographee',
	'namespace' => 'BuzzingPixel\Addons\Typographee',
	'version' => TYPOGRAPHEE_VER,
	'services' => array(
		'TypographyService' => 'Service\Typography'
	)
);