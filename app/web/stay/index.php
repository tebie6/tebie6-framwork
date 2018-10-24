<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/9/28
 * Time: 下午4:37
 */

$GLOBALS['start_time'] = microtime(true);

$errors = [];

try{

    (new \services\ted\Application())->run();
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