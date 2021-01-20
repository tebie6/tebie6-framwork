<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/9/28
 * Time: 下午4:34
 */

namespace app\controllers;

use app\models\BlogArticle;
use services\ted\Application;
use services\ted\Redis;
use Ted;

/**
 * Class HomeController
 * @package app\controllers
 */
class HomeController extends BaseController
{

    public function __construct()
    {
        $this->layout = 'layout/main';
    }

    public function actionHome(){
        $data = [
            'article'   =>  BlogArticle::testSearch()
        ];

        $data['article'] = [
            'title' => '标题',
            'content' => 'content',
        ];
        return $this->render('home',$data);
    }

    public function actionIndex(){

//        Ted::$app->redis->set('test',123456);
//        echo Ted::$app->redis->::get('test');

        $data = [
            'article'   =>  BlogArticle::testSearch()
        ];

        return 'this is home/index';
//        return [];
//        return $this->render('home',$data);
    }
}