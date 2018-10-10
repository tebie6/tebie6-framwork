<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/9/28
 * Time: 下午4:34
 */

namespace app\controllers;

use app\models\BlogArticle;
use services\Redis;

class HomeController extends BaseController
{

    public function actionHome(){

        $data = [
            'article'   =>  BlogArticle::first(['title'])
        ];

        return $this->render('home',$data);
    }

    public function actionIndex(){

        Redis::set('test',123456);
        echo Redis::get('test');
        
        $data = [
            'article'   =>  BlogArticle::first(['title'])
        ];

        return 'this is home/index';
//        return [];
//        return $this->render('home',$data);
    }
}