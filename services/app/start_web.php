<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/10/22
 * Time: 5:25 PM
 */

use common\components\workerman\Worker;
use common\components\workerman\WebServer;

// WebServer
$web = new WebServer("http://0.0.0.0:8080");

// WebServer进程数量
$web->count = 2;
// 设置站点根目录  TODO 日了狗 workerman 不支持入口文件名称定义 默认 index.php 或 index.html
$web->addRoot('test.tebie6.com', APP_PATH. '/web');


// 如果不是在根目录启动，则运行runAll方法
if(!defined('GLOBAL_START'))
{
    Worker::runAll();
}