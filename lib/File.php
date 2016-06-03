<?php namespace Teppanyaki\lib;

class File {
	
	/**
	 * Load a data file into a STRING
	 * @param string $file
	 */
	final public static function load_data_file ($file) {
		return file_get_contents($file);
	}
	
	/**
	 * Load a JSON file into an ASSOC
	 * @param string $file
	 */
	final public static function load_json_asoc ($file) {
		return json_decode(file_get_contents($file), true);
	}
	
	/**
	 * Loads a JSON file into an ARRAY
	 * @param string $file
	 */
	final public static function load_json_non_asoc ($file) {
		return json_decode(file_get_contents($file));
	}
}
