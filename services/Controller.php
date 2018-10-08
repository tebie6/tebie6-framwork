<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/9/29
 * Time: 下午4:06
 */
namespace services;

//基类

class Controller
{

    protected $view;

    /**
     * 渲染视图 【渲染布局】
     * @param $viewName
     * @param array $data
     * @return mixed
     */
    public function render($viewName, $data = []){

        // 渲染模版
        return View::render($viewName, $data);
    }

    /**
     * 渲染视图 【不渲染布局】
     * @param $viewName
     * @param array $data
     * @return mixed
     */
    public function renderPartial($viewName, $data = []){

        // 渲染模版
        return View::renderPartial($viewName, $data);
    }
}