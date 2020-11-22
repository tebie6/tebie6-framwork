<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/10/23
 * Time: 9:12 PM
 */

namespace services\ted;
use Ted;

/**
 * Class Application
 * @property \services\ted\Request $request
 */

class Application
{

    /**
     * 全局配置
     * @var array
     */
    public $config;

    public function __construct($config = [])
    {
        // 实例化核心组件
        foreach ( $this->coreComponents() as $_k=>$_v){
            $this->$_k = new $_v['class']();
        }

        // 初始配置
        $this->config = $config;
    }

    /**
     * 程序执行方法
     */
    public function run(){

        Ted::$app = $this;

        // 路由配置、开始处理
        require APP_PATH.'/config/routes.php';
    }


    /**
     * 核心组件
     * @inheritdoc
     */
    public function coreComponents()
    {
        return [
            'request' => ['class' => 'services\ted\Request'],
        ];
    }

//    public function __get($name)
//    {
//        // TODO: Implement __get() method.
//
//        $className = "services\\ted\\".ucfirst($name);
//        return new $className();
//
//    }
}