<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

// Include configuration
include(PATH_THIRD . 'typographee/config.php');

/**
 * Typographee extension
 *
 * @package typographee
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/ee-add-ons/typographee
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

class Typographee_ext
{
	public $name = TYPOGRAPHEE_NAME;
	public $version = TYPOGRAPHEE_VER;
	public $description = TYPOGRAPHEE_DESC;
	public $docs_url = 'https://buzzingpixel.com/ee-add-ons/typographee/documentation';
	public $settings_exist	= 'y';
	public $settings = array();

	public function __construct($settings = array())
	{
		$this->settings = $settings;
	}

	/**
	 * Activate extension
	 *
	 * @return void
	 */
	public function activate_extension()
	{
		ee()->db->insert('extensions', array(
			'class' => __CLASS__,
			'method' => 'parse_wygwam_typography',
			'hook' => 'wygwam_before_save',
			'settings' => '',
			'priority' => 10,
			'version' => $this->version,
			'enabled' => 'y'
		));
	}

	/**
	 * Update extension
	 *
	 * @return bool
	 */
	public function update_extension($current = '')
	{
		return false;
	}

	/**
	 * Disable extension
	 *
	 * @return void
	 */
	public function disable_extension()
	{
		ee()->db->where('class', __CLASS__);
		ee()->db->delete('extensions');
	}

	/**
	 * Extension settings
	 *
	 * @return array
	 */
	public function settings()
	{
		ee()->load->add_package_path(PATH_THIRD . 'typographee/');
		ee()->load->model('typographee_model');

		// Start the settings array
		$settings = array(
			'wygwam_configs' => array(
				'ms',
				array(),
				array()
			)
		);

		// Get the WYGWAM configuration
		$wygwamConfigs = ee()->typographee_model->getWygwamConfigs();

		// If the response from the model is a boolean, WYGWAM is not installed
		if (gettype($wygwamConfigs) === 'boolean') {
			$settings['wygwam_configs'][1]['n'] = lang('wygwam_not_installed');

			return $settings;
		}

		// If the model response is an empty array, there are no WYGWAM configs
		if (! $wygwamConfigs) {
			$settings['wygwam_configs'][1]['n'] = lang('no_wygwam_configs');

			return $settings;
		}

		// Populate the settings select
		foreach ($wygwamConfigs as $config) {
			$settings['wygwam_configs'][1][$config['config_id']] = $config['config_name'];
		}

		return $settings;
	}

	/**
	 * Parse WYGWAM data through EE typography parser
	 *
	 * @return void
	 */
	public function parse_wygwam_typography($wygwam, $data)
	{
		// If no settings, or config not in settings, just return the data
		if (! isset($this->settings['wygwam_configs'])) {
			return $data;
		}

		// If config not in settings, just return the data
		if (! in_array($wygwam->settings['config'], $this->settings['wygwam_configs'])) {
			return $data;
		}

		// Load the typgraphy library and return the data
		ee()->load->library('typographee_lib');

		return ee()->typographee_lib->typographyParser($data);
	}
}