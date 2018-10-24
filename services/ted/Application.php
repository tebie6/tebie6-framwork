<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/10/23
 * Time: 9:12 PM
 */

namespace services\ted;
use Fuck;

/**
 * Class Application
 * @property \services\ted\Request $request
 */
class Application
{

    public function __construct()
    {
        // 实例化核心组件
        foreach ( $this->coreComponents() as $_k=>$_v){
            $this->$_k = new $_v['class']();
        }
    }

    public function run(){

        Fuck::$app = $this;

        // 路由配置、开始处理
        require APP_PATH.'/config/routes.php';
    }


    /**
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