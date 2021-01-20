<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/9/28
 * Time: 下午5:32
 */
namespace app\models;
use services\ted\Db\Model;

/**
 * Class BlogArticle
 * @package app\models
 */
class BlogArticle extends Model
{

    public static $_tableName = 'blog_article';

    public static function testSearch(){

        // 详情查看 common\components\workerman\mysql\Connection 类
        return self::db()->from(self::$_tableName)->limit('id')->query();
    }
}