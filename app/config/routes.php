<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/9/28
 * Time: 下午3:55
 */

$routes = Ted::$app->routes;
$routes::get('', 'app\controllers\HomeController@home');

$routes::haltOnMatch();
$routes::error('website\controllers\IndexController@404');

$routes::dispatch();