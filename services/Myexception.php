<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/10/15
 * Time: 下午2:16
 */

// 异常处理类
class Myexception extends Exception{


    /**
     * @desc 	异常处理函数
     * @parm 	object $e 异常对象
     */
    public static function exceptionHandler($e){

        $file 	= $e->getFile();
        $line 	= $e->getLine();
        $code 	= $e->getCode();
        $message= $e->getMessage();

        // 获取应用配置文件
        $config = require dirname(__DIR__).DIRECTORY_SEPARATOR.APP_NAME.DIRECTORY_SEPARATOR.'config/main.php';
        if(!isset($config['runtimePath']) || empty($config['runtimePath'])){
            $config['runtimePath'] = dirname(__DIR__).DIRECTORY_SEPARATOR.APP_NAME.DIRECTORY_SEPARATOR.'log/error/';
        }

        $message = [
            '_server'   =>  $_SERVER,
            'error_message' =>  $message,
        ];
        (new \services\Logger())->add($config['runtimePath'].'/error', LOG_ERR, var_export($message, true),['file'=>$file,'line'=>$line]);
    }
    /**
     * @desc 	错误处理函数
     *
     */
    public static function errorHandler($errno,$errstr,$errfile,$errline){
        self::exceptionHandler(new \ErrorException($errstr,$errno,0,$errfile,$errline));
    }

    /**
     *
     *
     */
    public static function shutdownHandler(){
        $error = error_get_last();
        if($error){
            self::exceptionHandler(new \ErrorException($error['message'],$error['type'],0,$error['file'],$error['line']));
        }
    }
}