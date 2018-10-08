<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/10/8
 * Time: 下午5:03
 */

class Fuck
{

    public static $classMap = [];


    /**
     * 自动加载类库
     * @param $className
     */
    public static function autoload($className){

        // 判断是否已加载过
        if(isset($className[$className])){

            return ;

        // 判断是否为应用下的文件
        } elseif (strpos($className,'\\')) {

            $classFile = BASE_PATH.'/'.str_replace('\\','/',$className).'.php';
            if($classFile === false || !is_file($classFile)){

                return ;
            }
        } else {

            return ;
        }

        include $classFile;
        self::$classMap[$className] = $className;
    }
}