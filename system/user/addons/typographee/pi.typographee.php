<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Typographee plugin
 *
 * @package typographee
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/ee-add-ons/typographee
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

class Typographee
{
	/**
	 * Process parse tag pair
	 *
	 * @return string
	 */
	public function parse()
	{
		$typographyService = ee('typographee:TypographyService');

		// Check text format param
		$allowedTextFormat = array('all', 'xhtml', 'br', 'lite');
		$textFormat = ee()->TMPL->fetch_param('text_format', 'all');

		if (! in_array($textFormat, $allowedTextFormat)) {
			$textFormat = 'all';
		}

		// Check html format param
		$allowedHtmlFormat = array('all', 'safe', 'none');
		$htmlFormat = ee()->TMPL->fetch_param('html_format', 'all');

		if (! in_array($htmlFormat, $allowedHtmlFormat)) {
			$htmlFormat = 'all';
		}

		// Get remaining params
		$autoLinks = ee()->TMPL->fetch_param('auto_links') === 'yes' ? 'y' : 'n';
		$allowImgUrl = ee()->TMPL->fetch_param('allow_img_url') === 'no' ? 'n' : 'y';

		// Set up prefs
		$prefs = array(
			'text_format' => $textFormat,
			'html_format' => $htmlFormat,
			'auto_links' => $autoLinks,
			'allow_img_url' => $allowImgUrl
		);

		return $typographyService->parse(ee()->TMPL->tagdata, $prefs);
	}
}