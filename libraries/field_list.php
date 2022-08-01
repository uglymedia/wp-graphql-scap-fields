<?php

namespace scap_graphql\libraries;

class field_list {
	private static $wpdb;
	private static bool $initiated = false;

	private static array $field_list;

	private static string $field_prefix;

	public static function init(){
		if(self::$initiated)
			return;

		global $wpdb;
		self::$wpdb = $wpdb;

		self::set_field_prefix();
		self::retrieve_field_data();
	}

	/**
	 * Determine whether or not a field is valid.
	 *
	 * @param string $field_name
	 * @return bool
	 */
	public static function is_valid_field(string $field_name){
		if(isset(self::$field_list[self::$field_prefix . $field_name]))
			return true;

		if(isset(self::$field_list[$field_name]))
			return true;

		return false;
	}

	/**
	 * Retrieve the field list as an array.
	 *
	 * @return array
	 */
	public static function get_field_list(){
		return self::$field_list;
	}

	/**
	 * Returns the field prefix.
	 *
	 * @return string
	 */
	public static function get_field_prefix(){
		return self::$field_prefix;
	}

	/**
	 * Retrieves field data from the database.
	 *
	 * @return void
	 */
	private static function retrieve_field_data($force = false){
		if(!$force && !empty(self::$field_list))
			return;

		$results = self::$wpdb->get_results("
			SELECT
				cf.id,
				cf.name as field_name,
				cf.slug,
				cf.description,
				cf.date_created
			FROM `" . self::$wpdb->prefix . "um_cap_fields` cf");

		self::$field_list = [];

		if(empty($results))
			return;

		foreach($results as $row){
			self::$field_list[$row->slug] = $row;
		}
	}

	/**
	 * Gets the prefix for user metadata options.
	 *
	 * @return void
	 */
	private static function set_field_prefix(){
		if(!empty(self::$field_prefix))
			return;

		$custom_field_prefix = get_option('um_cap_custom_field_prefix');

		if($custom_field_prefix){
			self::$field_prefix = $custom_field_prefix;
		} else {
			self::$field_prefix = "um_cap_";
		}
	}
}