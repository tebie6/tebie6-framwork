<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/9/29
 * Time: 下午2:45
 */

use Illuminate\Database\Capsule\Manager as Capsule;

// 定义 BASE_PATH
define('BASE_PATH', __DIR__);

// 引入Fuck 核心文件
require BASE_PATH.'/services/Fuck.php';

// 注册Fuck 自动加载类
if(function_exists('spl_autoload_register')) {

    spl_autoload_register(['Fuck','autoload'],true,true);
} else {

    //TODO 稍后做兼容处理
    die('PHP版本条件 (PHP 5 >= 5.1.0, PHP 7)');
}

// Autoload 自动载入
require BASE_PATH.'/vendor/autoload.php';

// Eloquent ORM
$capsule = new Capsule;

$capsule->addConnection(require BASE_PATH.'/common/config/database.php');

$capsule->bootEloquent();


// whoops 错误提示
$whoops = new \Whoops\Run;

$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);

$whoops->register();