<?php namespace Teppanyaki;


class TeppanyakiChef {
	
	/**
	 * The TepenyakiChef will prepare a dish with a specified recipe
	 * for the given restaurant
	 * @param string $recipe
	 * @param string $ingredients
	 * @throws \Exception
	 */
	public static function prepare ($recipe=false, $ingredients=false) {
				
		if (!$recipe or !$ingredients)
			throw new \Exception("Tepenyaki Chef needs the recipe and ingredients to slice 'n' dice!");

		# Find the book & page
		$recipe = self::find_recipe_book($recipe);
		
		# Cook the recipe!
		try {
			$result = $recipe['book']::$recipe['page'] ($ingredients);
		} catch (Exception $e) {
			echo 'The chef could not open the cookery book! [',  $e->getMessage(), "]\n";
		}
		
		# Return result
		return $result;
	}
	
	
	/**
	 * Finds the recipe book and builds the Class path
	 * @param unknown $recipe
	 * @throws Exception
	 * @return string
	 */
	private static function find_recipe_book ($recipe) {

		if (!recipe or !isset($recipe) or empty($recipe) or !strpos($recipe, '\\'))
			throw new Exception('The chef could not find the cookery book & page because the information given to him was incorrect!');
		
		# Split Book & Recipe
		try {
			list($book, $page) = explode('\\', $recipe);
		} catch (Exception $e) {
		    echo 'The chef did not get enough information regarding which recipe book to find! [',  $e->getMessage(), "]\n";
		}
		
		# Build Recipe Object
		$out['book'] = __NAMESPACE__ . '\\Recipes\\' . $book;
		$out['page'] = $page;
		
		return $out;
	}
}
