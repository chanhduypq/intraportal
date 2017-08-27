<?php

defined('YII_DEBUG') or define('YII_DEBUG',true);
define('MAIN_CONFIG',dirname(__FILE__).'/../../protected/config/console.php');

$yii=dirname(__FILE__).'/../../framework/yii.php';

require_once($yii);
$config= MAIN_CONFIG;

$app = Yii::createConsoleApplication($config);
$app->run();
