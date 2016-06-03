<?php namespace Teppanyaki\lib;

class File {
	
	/**
	 * Load a data file into a STRING
	 * @param string $file
	 */
	final public static function load_data_file ($file_path) {
		if (!file_exists($file_path))
			throw new \Exception ('Chef could not locate the ingredients file!');
		return file_get_contents($file_path);
	}
	
	/**
	 * Load a JSON file into an ASSOC
	 * @param string $file
	 */
	final public static function load_json_asoc ($file_path) {
		if (!file_exists($file_path))
			throw new \Exception ('Chef could not locate the ingredients file!');
		return json_decode(file_get_contents($file_path), true);
	}
	
	/**
	 * Loads a JSON file into an ARRAY
	 * @param string $file
	 */
	final public static function load_json_non_asoc ($file_path) {
		if (!file_exists($file_path))
			throw new \Exception ('Chef could not locate the ingredients file!');
		return json_decode(file_get_contents($file_path));
	}
	
	/**
	 * Saves a JSON file from an ASSOC ARRAY
	 * @param mixed $data_assoc
	 * @param string $file_path
	 */
	final public static function save_json ($file_path, $assoc_array) {
		
		if (is_dir($file_path))
			throw new \Exception ('File path provided is a directory, not a file!');
			
		if (!isset($file_path) or empty($file_path))
			throw new \Exception ('File path was empty!');
		
		return file_put_contents($file_path, json_encode($assoc_array, JSON_UNESCAPED_SLASHES));
	}
}
