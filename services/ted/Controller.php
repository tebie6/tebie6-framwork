<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/9/29
 * Time: 下午4:06
 */
namespace services\ted;

//基类

class Controller
{

    /**
     * @var null|string|false 设置layout 文件名
     */
    public $layout = false;

    public $config;

    public function __construct()
    {

        // 载入配置文件
        $this->loadConfig();


    }

    /**
     * 渲染视图 【渲染布局】
     * @param $viewName
     * @param array $data
     * @return mixed
     */
    public function render($viewName, $data = []){

        // 渲染模版
        return View::render($viewName, $data, $this->layout);
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

    /**
     * 返回JSON数据
     * @param $code
     * @param string $msg
     * @param array $data
     */
    public function renderJson($code, $msg = '', array $data =[]){

        $response = [
            'error_code'    =>  intval($code),
            'message'       =>  $msg,
            'data'          =>  $data,
        ];
        header('Content-Type: application/json; charset=utf-8', true);

        echo json_encode($response, JSON_FORCE_OBJECT);
    }

    /**
     * 加载配置
     */
    private function loadConfig(){

        $config = require dirname(__DIR__).'/'.APP_NAME.'/config/main.php';
        $this->config = array_to_object($config);

        echo "<pre>";
        print_r($this->config);die;
        if(isset($this->config->layout)){
            echo 1;die;
        }
    }
}