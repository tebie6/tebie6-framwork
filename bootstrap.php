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

// 引入 utilty
require BASE_PATH.'/common/utilty.php';

// 引入Fuck 核心文件
require BASE_PATH.'/services/Fuck.php';

// Autoload 自动载入
require BASE_PATH.'/vendor/autoload.php';

// Eloquent ORM
$capsule = new Capsule;

$capsule->addConnection(require APP_PATH.'/../config/database.php');

$capsule->bootEloquent();


// whoops 错误提示
$whoops = new \Whoops\Run;

$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);

$whoops->register();