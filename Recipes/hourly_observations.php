<?php namespace Teppanyaki\Recipes;

use Teppanyaki\lib\File;


class hourly_observations {
	
	protected static $memory_limit = '128M';

	/**
	 * Loads all observations file and slices into separate
	 * locational files for each change in loaction ID
	 * @param string $file
	 */
	public static function hourly_site_observations_all_sites_all_timestamps ($ingredients) {
		if (!$ingredients)
			throw new Exception ("The chef has the recipe, but doesn't have any ingredients to make it!");
		
		# Set memory limit
		ini_set('memory_limit', self::$memory_limit);
		
		# Load the JSON file to slice & dice!
		$json = File::load_json_asoc($ingredients);
		
		# Run tests on data
		self::test_ingredients ($json);
	
		# Get the header information
		$header = $json['SiteRep']['Wx'];
	
		# Run through locations and build files.
		foreach ($json['SiteRep']['DV']['Location'] as $site) {
				
			# If no ID then skip
			if (empty($site['i']) or !isset($site['i']))
				continue;
					
				# Build JSON structure
				$tmpSite = [
						'SiteRep' => [
							'Wx' => $header,
							'DV' => [
								'dataDate' => $json['SiteRep']['DV']['dataDate'],
								'type'     => $json['SiteRep']['DV']['type'],
								'Location' => $site
						]
					]
				];
					
				# Output slice into json file
				try {
					
					File::save_json ('./data/hourly_observations_' . $site['i'] . '.json', $tmpSite);
					
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
			throw new Exception ('Ingredients JSON file does not appear to be loaded. The chef is not happy!');
		
		if (
			!isset($json['SiteRep']) or 
			!isset($json['SiteRep']['DV']) or 
			!isset($json['SiteRep']['DV']['Location']) or 
			count($json['SiteRep']['DV']['Location']) < 1
		)
			throw new Exception ('Ingredients JSON file does not appear to have the correct items. The chef is not happy!');
		
		return true;
	}
}
