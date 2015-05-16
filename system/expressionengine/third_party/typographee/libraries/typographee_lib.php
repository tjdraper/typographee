<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Typographee library
 *
 * @package typographee
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/ee-add-ons/typographee
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

class Typographee_lib
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
	public function typographyParser($data = '', $prefs = array())
	{
		ee()->load->library('typography');
		ee()->typography->initialize();

		$defaultPrefs = array(
			'text_format' => 'all',
			'html_format' => 'all',
			'auto_links' => 'n',
			'allow_img_url' => 'y'
		);

		$prefs = array_merge($defaultPrefs, $prefs);

		return ee()->typography->parse_type($data, $prefs);
	}
}