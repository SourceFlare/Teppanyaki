<?php namespace Teppanyaki;

use Teppanyaki\TeppanyakiChef;

include_once('autoload.php');

echo TeppanyakiChef::prepare (
	$argv[1], $argv[2]
);
