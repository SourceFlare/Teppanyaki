<?php spl_autoload_register(function($className)
{
	$classname = str_replace('\\', '/', $classname);
	
    $class = __DIR__ . '/' . str_replace("Teppanyaki\\", '', $className) . '.php';
    
    # Check if Class Exists & Include
    if (file_exists($class))
        require($class);
});
