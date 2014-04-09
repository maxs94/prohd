<?php

// change the following paths if necessary
$yiic='/usr/local/lib/yii1.1.5/yii.php';
$config=dirname(__FILE__).'/config/console.php';

require_once($yiic);
 
// creating and running console application
Yii::createConsoleApplication($config)->run();
