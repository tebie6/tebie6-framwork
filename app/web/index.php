<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/9/28
 * Time: 下午4:37
 */

// 定义 APP_PATH
define('APP_NAME', 'app');
define('APP_PATH', dirname(__DIR__));

// 启动器
require_once APP_PATH.'/../bootstrap.php';

(new \services\ted\Application())->run();
