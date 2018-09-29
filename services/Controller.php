<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/9/29
 * Time: 下午4:06
 */
namespace service;

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
        $this->view = View::make($viewName)->setData($data);
        return $this->requireView();
    }

    /**
     * 渲染视图 【不渲染布局】
     * @param $viewName
     * @param array $data
     * @return mixed
     */
    public function renderPartial($viewName, $data = []){

        // 渲染模版
        $this->view = View::make($viewName)->setData($data);
        return $this->requireView();
    }

    /**
     * 引入View 文件
     * @return mixed
     */
    public function requireView(){
        $view = $this->view;

        // instanceof 作用：（1）判断一个对象是否是某个类的实例，（2）判断一个对象是否实现了某个接口。
        if ( $view instanceof View ) {

            // extract — 从数组中将变量导入到当前的符号表
            // 例如 extract(['color'=>'blue','age'=>18,'gender'=>'man'])
            // echo "$color, $age, $gender"

            extract($view->data);

            // 引用视图文件
            return require $view->view;
        }
    }
}