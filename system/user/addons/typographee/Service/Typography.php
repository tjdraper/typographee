<?php

namespace BuzzingPixel\Addons\Typographee\Service;

class Typography
{
	/**
	 * Process string through EE typography library
	 *
	 * @param string $data String to run through the typography parser
	 * @param array $prefs the typopgraphy library preferences {
	 *     @var string $text_format all|xhtml|br|lite
	 *     @var string $html_format all|safe|none
	 *     @var string $auto_links y|n
	 *     @var string $allow_img_url y|n
	 * }
	 * @return string
	 */
	public function parse($data = '', $prefs = array())
	{
		ee()->load->library('typography');
		ee()->typography->initialize();

		// Fix EE mangling URLs in markup
		$old_method = isset($_GET['M']) ? $_GET['M'] : false;
		$_GET['M'] = 'send_email';

		// Set default prefs
		$defaultPrefs = array(
			'text_format' => 'all',
			'html_format' => 'all',
			'auto_links' => 'n',
			'allow_img_url' => 'y'
		);

		// Merge in custom prefs
		$prefs = array_merge($defaultPrefs, $prefs);

		// Parse data through typography class
		$data = ee()->typography->parse_type($data, $prefs);

		// Return EE to defaults
		if ($old_method) {
			$_GET['M'] = $old_method;
		} else {
			unset($_GET['M']);
		}

		return $data;
	}
}