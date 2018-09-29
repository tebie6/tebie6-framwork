<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/9/28
 * Time: 下午4:34
 */

namespace app\controllers;

use app\models\BlogArticle;
use app\controllers\BaseController;

class HomeController extends BaseController
{

    public function home(){

        $data = [
            'article'   =>  BlogArticle::first(['title'])
        ];
        return $this->render('home',$data);
//        $this->view = View::make('home')->with('article',BlogArticle::first(['title']))
//
//            ->withTitle('MFFC :-D')
//
//            ->withFuckMe('OK!');

//        echo "<h1>控制器成功！</h1>";die;
//
//        $article = BlogArticle::first()->toArray();
//        echo "<pre>";
//        print_r($article);die;
//        require dirname(__FILE__).'/../views/home.php';
    }
}