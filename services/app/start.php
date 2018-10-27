<?php

use \Workerman\Worker;

// 检测运行环境
if(strpos(strtolower(PHP_OS), 'win') === 0) {
    exit("start.php not support windows, please use start_for_win.bat\n");
}

// 检查扩展
if(!extension_loaded('pcntl')) {
    exit("Please install pcntl extension. See http://doc3.workerman.net/appendices/install-extension.html\n");
}

if(!extension_loaded('posix')) {
    exit("Please install posix extension. See http://doc3.workerman.net/appendices/install-extension.html\n");
}

$GLOBALS['stay'] = true;

// 标记是全局启动
define('GLOBAL_START', 1);

// 定义 APP_PATH
define('APP_NAME', 'app');
define('APP_PATH', __DIR__.'/../../'.APP_NAME);

// 启动器
require_once dirname(__DIR__).'/../bootstrap.php';

// 加载配置
$GLOBALS['config'] = require_once APP_PATH . DIRECTORY_SEPARATOR . 'config' .DIRECTORY_SEPARATOR .'main.php';

// 设置log路径
Worker::$stdoutFile = __DIR__.'/stdout.log';
Worker::$logFile = __DIR__.'/workerman.log';

// 加载所有Applications/*/start.php，以便启动所有服务
foreach(glob(__DIR__.'/start_*.php') as $start_file) {
    require_once $start_file;
}

// 运行所有worker服务
Worker::runAll();
