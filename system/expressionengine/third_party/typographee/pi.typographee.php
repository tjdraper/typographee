<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

// Include configuration
include(PATH_THIRD . 'typographee/config.php');

/**
 * Typographee plugin
 *
 * @package typographee
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/ee-add-ons/typographee
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

$plugin_info = array (
	'pi_name' => TYPOGRAPHEE_NAME,
	'pi_version' => TYPOGRAPHEE_VER,
	'pi_author' => TYPOGRAPHEE_AUTHOR,
	'pi_author_url' => TYPOGRAPHEE_AUTHOR_URL,
	'pi_description' => TYPOGRAPHEE_DESC
);

class Typographee
{
	/**
	 * Process parse tag pair
	 *
	 * @return string
	 */
	public function parse()
	{
		ee()->load->library('typographee_lib');

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

		return ee()->typographee_lib->typographyParser(
			ee()->TMPL->tagdata,
			$prefs
		);
	}
}