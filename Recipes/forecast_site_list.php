<?php namespace Teppanyaki\Recipes;

use Teppanyaki\lib\File;


class forecast_site_list {
	
	protected static $memory_limit = '128M';
	
	
	
	/**
	 * Builds a JSON list of Unitary Auth Areas in the Forecast_Site_List JSON File
	 * @param string $ingredients
	 * @throws \Exception
	 * @return boolean
	 */
	public static function unitary_auth_area_list ($ingredients) {
		if (!$ingredients)
			throw new \Exception ("The chef has the recipe, but doesn't have any ingredients to make it!");
		
		# Set memory limit
		ini_set('memory_limit', self::$memory_limit);
		
		# Load the JSON file to slice & dice!
		$json = File::load_json_asoc($ingredients);
		
		# Run tests on data
		self::test_ingredients ($json);
		
		# Build an ASSOC for each UnitaryAuthArea (eg:  Swindon has three locations)
		foreach ($json['Locations']['Location'] as $loc) {
			
			# If no unitaryAuthArea set then skip
			if (!isset($loc['unitaryAuthArea']) or empty($loc['unitaryAuthArea']))
				continue;
					
			$locations[$loc['unitaryAuthArea']] = count($loc);
		}
		
		# Sort Locations in ALPHA ASC
		ksort($locations);
		
		# Build JSON structure
		$tmpSite = [
			'Locations' => $locations
		];
					
		# Output slice into json file
		try {
			File::save_json ('./data/unitary_auth_area_list.json', $tmpSite);				
		} catch (Exception $e) {
			echo 'The chef had a problem serving the dish to the customer! [',  $e->getMessage(), "]\n";
		}
		
		return true;
	}
	
	/**
	 * Builds a file for each Unitary Auth Area in the Forecast_Site_List JSON File
	 * @param string $ingredients
	 * @throws \Exception
	 * @return boolean
	 */
	public static function unitary_auth_areas ($ingredients) {
		if (!$ingredients)
			throw new \Exception ("The chef has the recipe, but doesn't have any ingredients to make it!");
		
		# Set memory limit
		ini_set('memory_limit', self::$memory_limit);
		
		# Load the JSON file to slice & dice!
		$json = File::load_json_asoc($ingredients);
		
		# Run tests on data
		self::test_ingredients ($json);
		
		# Build an ASSOC for each UnitaryAuthArea (eg:  Swindon has three locations)
		foreach ($json['Locations']['Location'] as $loc) {
			
			# If no unitaryAuthArea set then skip
			if (!isset($loc['unitaryAuthArea']) or empty($loc['unitaryAuthArea']))
				continue;
					
			$locations[$loc['unitaryAuthArea']][] = $loc;
		}
		
		# Output a JSON file for each UnitaryAuthArea
		foreach ($locations as $UnitaryAuthArea => $location_data) {
			
			# If no unitaryAuthArea name set then skip
			if (!isset($UnitaryAuthArea) or empty($UnitaryAuthArea))
				continue;
			
			# Build JSON structure
			$tmpSite = [
				'Locations' => [
					'UnitaryAuthArea' => $UnitaryAuthArea,
					'Locations'       => $location_data
				]
			];
						
			# Output slice into json file
			try {
				File::save_json ('./data/unitary_auth_area_' . str_replace(' ', '_', $UnitaryAuthArea) . '.json', $tmpSite);				
			} catch (Exception $e) {
				echo 'The chef had a problem serving the dish to the customer! [',  $e->getMessage(), "]\n";
			}
		}
		
		return true;
	}
	
	
	
	
	
	/**
	 * Builds a JSON list of the REGIONS in the Forecast_Site_List JSON File
	 * @param string $ingredients
	 * @throws \Exception
	 * @return boolean
	 */
	public static function region_list ($ingredients) {
		if (!$ingredients)
			throw new \Exception ("The chef has the recipe, but doesn't have any ingredients to make it!");
		
		# Set memory limit
		ini_set('memory_limit', self::$memory_limit);
		
		# Load the JSON file to slice & dice!
		$json = File::load_json_asoc($ingredients);
		
		# Run tests on data
		self::test_ingredients ($json);
		
		# Build an ASSOC for each UnitaryAuthArea (eg:  Swindon has three locations)
		foreach ($json['Locations']['Location'] as $loc) {
			
			# If no unitaryAuthArea set then skip
			if (!isset($loc['region']) or empty($loc['region']))
				continue;
					
			$locations[$loc['region']] = true;
		}
		
		# Sort Locations in ALPHA ASC
		ksort($locations);
		
		# Build JSON structure
		$tmpSite = [
			'Locations' => $locations
		];
					
		# Output slice into json file
		try {
			File::save_json ('./data/region_list.json', $tmpSite);				
		} catch (Exception $e) {
			echo 'The chef had a problem serving the dish to the customer! [',  $e->getMessage(), "]\n";
		}
		
		return true;
	}
	
	/**
	 * Builds a JSON file for each REGION in the Forecast_Site_List JSON File
	 * @param string $ingredients
	 * @throws \Exception
	 * @return boolean
	 */
	public static function regions ($ingredients) {
		if (!$ingredients)
			throw new \Exception ("The chef has the recipe, but doesn't have any ingredients to make it!");
		
		# Set memory limit
		ini_set('memory_limit', self::$memory_limit);
		
		# Load the JSON file to slice & dice!
		$json = File::load_json_asoc($ingredients);
		
		# Run tests on data
		self::test_ingredients ($json);
		
		# Build an ASSOC for each UnitaryAuthArea (eg:  Swindon has three locations)
		foreach ($json['Locations']['Location'] as $loc) {
			
			# If no unitaryAuthArea set then skip
			if (!isset($loc['region']) or empty($loc['region']))
				continue;
					
			$locations[$loc['region']][] = $loc;
		}
		
		# Output a JSON file for each UnitaryAuthArea
		foreach ($locations as $Region => $location_data) {
			
			# If no unitaryAuthArea name set then skip
			if (!isset($Region) or empty($Region))
				continue;
			
			# Build JSON structure
			$tmpSite = [
				'Locations' => [
					'Region'    => $Region,
					'Locations' => $location_data
				]
			];
						
			# Output slice into json file
			try {
				File::save_json ('./data/region_' . str_replace(' ', '_', $Region) . '.json', $tmpSite);				
			} catch (Exception $e) {
				echo 'The chef had a problem serving the dish to the customer! [',  $e->getMessage(), "]\n";
			}
		}
		
		return true;
	}
	
	
	
	
	/**
	 * Run some integrity checks on the input data
	 * @param mixed $json
	 * @throws Exception
	 * @return bool
	 */
	private static function test_ingredients ($json) {
		if (empty($json) or !isset($json))
			throw new \Exception ('Ingredients JSON file does not appear to be loaded. The chef is not happy!');
		
		if (
			!isset($json['Locations']) or 
			!isset($json['Locations']['Location']) or 
			!isset($json['Locations']['Location'][0])
		)
			throw new \Exception ('Ingredients JSON file does not appear to have the correct items. The chef is not happy!');
		
		return true;
	}
}
