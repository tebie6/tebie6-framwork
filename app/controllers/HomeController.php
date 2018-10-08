<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/9/28
 * Time: 下午4:34
 */

namespace app\controllers;

use app\models\BlogArticle;

class HomeController extends BaseController
{

    public function home(){

        $data = [
            'article'   =>  BlogArticle::first(['title'])
        ];

        return $this->render('home',$data);
    }

    public function index(){

        $data = [
            'article'   =>  BlogArticle::first(['title'])
        ];

        return 'this is home/index';
//        return [];
//        return $this->render('home',$data);
    }
}