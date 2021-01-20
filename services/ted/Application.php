<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/10/23
 * Time: 9:12 PM
 */

namespace services\ted;
use common\components\noahbuscher\macaw\Macaw;
use services\ted\Db\DbPool;
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
    public $db = null;
    public $redis = null;
    public $routes = null;

    public function __construct($config = [])
    {
        if (Ted::$init != null) return;

        // 实例化核心组件
        foreach ( $this->coreComponents() as $_k=>$_v){
            $this->$_k = new $_v['class']();
        }

        // 初始配置
        $this->config = $config;

        // 初始化路由
        $this->routes = new Macaw();

        // 初始化db、redis
        $this->db = DbPool::initDbConn();
        $this->redis = Redis::getConnect();

        // 加载常量
        $this->params = require_once BASE_PATH . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . 'config' .DIRECTORY_SEPARATOR .'params.php';
    }

    /**
     * 程序执行方法
     */
    public function run(){

        if (Ted::$init == null){
            Ted::$app = $this;
            Ted::$init = true;
        }

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
}