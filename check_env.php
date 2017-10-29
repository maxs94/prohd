<?php

/*
** maxs94
** check if environment is setup correctly 
** note: must be executed from index.php
*/

$root_dir = dirname(__FILE__);

if (!file_exists($yii)) die("(index.php) ERROR: Yii Framework not found at " . $yii);

if (!file_exists($config)) die("(index.php) ERROR: main config file not found");
if (!file_exists($root_dir . "/protected/config/console.php")) die("(/protected/config/console.php) ERROR: config file not found.");

if (!is_writable($root_dir)) die("(root Directory) ERROR: Directory is not writeable. Cannot continue.");


if (!is_dir(dirname(__FILE__).'/assets')) {
	// create it 
	mkdir(dirname(__FILE__).'/assets');
}

// more checks done after login in SiteController.php, method check_db()

?>
