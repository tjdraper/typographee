<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Typographee model
 *
 * @package typographee
 * @author TJ Draper <tj@buzzingpixel.com>
 * @link https://buzzingpixel.com/ee-add-ons/typographee
 * @copyright Copyright (c) 2015, BuzzingPixel
 */

class Typographee_model extends CI_Model
{
	/**
	 * Get WYGWAM Configs
	 *
	 * @return false|array
	 */
	public function getWygwamConfigs()
	{
		if (! ee()->db->table_exists('wygwam_configs')) {
			return false;
		}

		// Query for the configs
		$query = ee()->db->select('config_id, config_name')
			->from('wygwam_configs')
			->order_by('config_name')
			->get()
			->result_array();

		return $query;
	}
}