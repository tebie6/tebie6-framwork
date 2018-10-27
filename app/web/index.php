<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/9/28
 * Time: 下午4:37
 */


if(isset($GLOBALS['stay'])){

    $GLOBALS['start_time'] = microtime(true);

    $errors = [];

    try{

        (new \services\ted\Application($GLOBALS['config']))->run();
//    echo "<br/>使用: ".memory_get_usage()."B<br/>";


    }catch(Exception $e){

        if($e instanceof \PDOException) {
            $errors = ['status'=>57777,'msg'=>'DB Process failed', 'data'=>[]];
        }else{
            $errors = ['status'=>$e->getCode(),'msg'=>$e->getMessage(), 'data'=>[]];
        }
        $exception = json_encode($errors);
        echo $exception;
    }

    (new \services\ted\Logger())->error((!empty($errors['msg']) ? $errors['msg'] : ''),'error');
}else{

    // 定义 APP_PATH
    define('APP_NAME', 'app');
    define('APP_PATH', dirname(__DIR__));

// 启动器
    require_once APP_PATH.'/../bootstrap.php';

// 加载配置
    $config = require_once APP_PATH . DIRECTORY_SEPARATOR . 'config' .DIRECTORY_SEPARATOR .'main.php';

    (new \services\ted\Application($config))->run();
    
}

