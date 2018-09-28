<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/9/28
 * Time: 下午4:34
 */

class HomeController extends BaseController
{

    public function home(){
        echo "<h1>控制器成功！</h1>";die;

        $article = BlogArticle::first()->toArray();
        echo "<pre>";
        print_r($article);die;
        require dirname(__FILE__).'/../views/home.php';
    }
}