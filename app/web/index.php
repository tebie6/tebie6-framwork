<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/9/28
 * Time: 下午4:37
 */

use Illuminate\Database\Capsule\Manager as Capsule;


// Autoload 自动载入
require __DIR__.'/../../vendor/autoload.php';

// Eloquent ORM
$capsule = new Capsule;

$capsule->addConnection(require '../config/database.php');

$capsule->bootEloquent();

// 路由配置
require __DIR__.'/../config/routes.php';

