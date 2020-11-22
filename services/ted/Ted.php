<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/10/8
 * Time: 下午5:03
 */
require __DIR__ . '/BaseTed.php';

/**
 * Class Ted
 */
class Ted extends \services\ted\BaseTed
{

}

// 注册Ted 自动加载类
if(function_exists('spl_autoload_register')) {

    spl_autoload_register(['Ted','autoload'],true,true);
} else {

    //TODO 稍后做兼容处理
    die('PHP版本条件 (PHP 5 >= 5.1.0, PHP 7)');
}