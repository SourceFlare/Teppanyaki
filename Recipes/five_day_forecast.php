<?php namespace Teppanyaki\Recipes;

use Teppanyaki\lib\File;


class five_day_forecast {
	
	protected static $memory_limit = '512M';
	
	/**
	 * Loads all observations file and slices into separate
	 * locational files for each change in loaction ID
	 * @param string $file
	 */
	public static function five_day_summarised_forecast_all_sites_all_timesteps ($ingredients) {
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
		
		# Splice each location into it's own file
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
					
					File::save_json ('./data/five_day_forecast_' . $site['i'] . '.json', $tmpSite);
					
				} catch (Exception $e) {
				    echo 'The chef had a problem serving the dish to the customer! [',  $e->getMessage(), "]\n";
				}
		}
		return true;
	}
	
	
	
	/**
	 * Loads all observations file and slices into separate
	 * locational files for each change in loaction ID
	 * @param string $file
	 */
	public static function five_day_summarised_forecast_all_sites_all_timesteps_simplified ($ingredients) {
		if (!$ingredients)
			throw new Exception ("The chef has the recipe, but doesn't have any ingredients to make it!");
		
		# Set memory limit
		ini_set('memory_limit', self::$memory_limit);
		
		# Load the JSON file to slice & dice!
		$json = File::load_json_asoc ($ingredients);
		
		# Run tests on data
		self::test_ingredients ($json);
	
		# Get the header information
		$header = $json['SiteRep']['Wx'];
		
		# Splice each location into it's own file
		foreach ($json['SiteRep']['DV']['Location'] as $site) {
				
			# If no ID then skip
			if (empty($site['i']) or !isset($site['i']))
				continue;
			
			foreach ($site['Period'] as $period => $day) {
				$date = $day['value'];
				
				/** Daytime **/
				
					# Max and Feels-Like Max Temps
					$avg[$date]['Day']['T'] = (float) $day['Rep'][0]['Dm'];      # Maximum Temperature
					$avg[$date]['Day']['F'] = (float) $day['Rep'][0]['FDm'];     # Feels-Like Maximum Temperature
					$avg[$date]['Day']['S'] = (float) $day['Rep'][0]['S'];		 # Wind Speed
					$avg[$date]['Day']['G'] = (float) $day['Rep'][0]['Gn'];	     # Wind Speed (Gusting)
					$avg[$date]['Day']['H'] = (float) $day['Rep'][0]['Hn'];	     # Hummidity
					$avg[$date]['Day']['P'] = (float) $day['Rep'][0]['PPd'];     # Precipitation Probability %
					$avg[$date]['Day']['U'] = (float) $day['Rep'][0]['U'];	     # UV Index

				/** Nighttime **/
					
					# Nighttime Max and Feels-Like Max Temps
					$avg[$date]['Night']['T'] = (float) $day['Rep'][1]['Nm'];    # Minimum Temperature
					$avg[$date]['Night']['F'] = (float) $day['Rep'][1]['FNm'];   # Feels-Like Minimum Temperature
					$avg[$date]['Night']['S'] = (float) $day['Rep'][1]['S'];     # Wind Speed
					$avg[$date]['Night']['G'] = (float) $day['Rep'][1]['Gm'];	 # Wind Speed (Gusting)
					$avg[$date]['Night']['H'] = (float) $day['Rep'][1]['Hm'];	 # Hummidity
					$avg[$date]['Night']['P'] = (float) $day['Rep'][1]['PPn'];	 # Precipitation Probability %
					$avg[$date]['Night']['U'] = (float) 0;	                     # UV Index
								
				/** Wholeday Averages **/
					
					# Wholeday Average of Max and Feels-Like Max Temps
					$avg[$date]['Whole']['T'] = (float) (($day['Rep'][0]['Dm']  + $day['Rep'][1]['Nm'])  / 2);
					$avg[$date]['Whole']['F'] = (float) (($day['Rep'][0]['FDm'] + $day['Rep'][1]['FNm']) / 2);
					$avg[$date]['Whole']['S'] = (float) (($day['Rep'][0]['S']   + $day['Rep'][1]['S'])   / 2);
					$avg[$date]['Whole']['G'] = (float) (($day['Rep'][0]['Gn']  + $day['Rep'][1]['Gm'])  / 2);
					$avg[$date]['Whole']['H'] = (float) (($day['Rep'][0]['Hn']  + $day['Rep'][1]['Hm'])  / 2);
					$avg[$date]['Whole']['P'] = (float) (($day['Rep'][0]['PPd'] + $day['Rep'][1]['PPn']) / 2);
					$avg[$date]['Whole']['U'] = (float) $day['Rep'][0]['U'];					
			}			

			# Build JSON structure
			$tmpSite = [
				'SiteRep' => [
					'Wx' => [
						'Param' => [
							['name' => 'T', 'units' => 'C',     '$' => 'Day Minimum/Maximum Temperature'],
							['name' => 'F', 'units' => 'C',     '$' => 'Day Minimum/Maximum Feels-Like Temperature'],
							['name' => 'S', 'units' => 'mph',   '$' => 'Feels Like Day Maximum Temperature'],
							['name' => 'G', 'units' => 'mph',   '$' => 'Wind Gust Day/Night'],
							['name' => 'H', 'units' => '%',     '$' => 'Hummidity Day/Night'],
							['name' => 'U', 'units' => 'units', '$' => 'UV Index']
						]
					],
					'DV' => [
					    'i'         => $site['i'],
					    'name'      => $site['name'],
					    'country'   => $site['country'],
					    'continent' => $site['continent'],
					    'lat'       => $site['lat'],
					    'lon'       => $site['lon'],
					    'elevation' => isset($site['elevation']) ? $site['elevation'] : false,
						'dataDate'  => $json['SiteRep']['DV']['dataDate'],
						'type'      => $json['SiteRep']['DV']['type'],
						'Period'    => $avg
					]
				]
			];
			
			# Output slice into json file
			try {
				
				# Write data to location file
				File::save_json ('./data/five_day_simplified_' . $site['i'] . '.json', $tmpSite);
			
				# clear Data
				$avg=''; $tmpSite='';
				
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
