<?php

// change the following paths if necessary
$yii = dirname(__FILE__) . '/framework/yii.php';
$config = dirname(__FILE__) . '/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once($yii);
Yii::createWebApplication($config)->run();




$content = date("Y/m/d H:i:s");
$content.=' [IP: ' . $_SERVER['REMOTE_ADDR'] . '] ';
if (is_numeric(FunctionCommon::getEmplNum())) {
    $content.=' [Employee Number: ' . FunctionCommon::getEmplNum() . '] ';
}
$content.=' [URL: ' . Yii::app()->request->url . '] ';
$content.=' [HTTP METHOD: ' . $_SERVER['REQUEST_METHOD'] . '] ';
$content.=' [Client: ' . $_SERVER['HTTP_USER_AGENT'] . '] ';


processLogs($content);

function rotateFiles() {
    $file = Config::LOG_PATH . Config::LOG_FILE_NAME;
    $max = 5;
    for ($i = $max; $i > 0;  --$i) {
        $rotateFile = $file . '.' . $i;
        if (is_file($rotateFile)) {
            
            if ($i === $max)
                @unlink($rotateFile);
            else
                @rename($rotateFile, $file . '.' . ($i + 1));
              //  system('\'mv ' . $rotateFile . ' ' . $file . '.' . ($i + 1) . '\'');
        }
    }
    if (is_file($file))
        @rename($file, $file . '.1'); 
}

function processLogs($content) {
    $logFile = Config::LOG_PATH . Config::LOG_FILE_NAME;
    if (@filesize($logFile) > Config::LOG_FILE_NAME_MAX_SIZE * 1024 * 1024)
        rotateFiles();
    $fp = @fopen($logFile, 'a');
    @flock($fp, LOCK_EX);
    $old_content=@fread($fp,@filesize($logFile));
    @fwrite($fp, $content."\n".$old_content);
    @flock($fp, LOCK_UN);
    @fclose($fp);
}
