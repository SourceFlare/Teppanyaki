<?php spl_autoload_register(function($className)
{
	
    $class = __DIR__ . '/' . str_replace("Teppanyaki\\", '', $className) . '.php';
	$class = str_replace('\\', '/', $class);
    
    # Check if Class Exists & Include
    if (file_exists($class))
        require($class);
});
