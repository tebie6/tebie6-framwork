<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/9/28
 * Time: 下午4:37
 */

// 定义 APP_PATH
define('APP_PATH', __DIR__);
define('APP_NAME', 'app');

// 启动器
require APP_PATH.'/../../bootstrap.php';

// 路由配置、开始处理
require APP_PATH.'/../config/routes.php';
