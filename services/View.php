<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/9/29
 * Time: 下午3:10
 */

namespace services;

class View
{
    const VIEW_BASE_PATH = '/app/views/';

    public $view;
    public $data;

    public function __construct($view)
    {
        $this->view = $view;
    }

    /**
     * 获取视图路径
     * @param null $viewName
     * @return View
     */
    public static function make($viewName = null)
    {
        if ( ! $viewName ) {
            throw new InvalidArgumentException("视图名称不能为空！");
        } else {

            $viewFilePath = self::getFilePath($viewName);
            if ( is_file($viewFilePath) ) {
                return new View($viewFilePath);
            } else {
                throw new UnexpectedValueException("视图文件不存在！");
            }
        }
    }

    /**
     * 绑定参数
     * @param $key
     * @param null $value
     * @return $this
     */
    public function with($key, $value = null)
    {
        $this->data[$key] = $value;
        return $this;
    }

    /**
     * 设置传递数据
     * @param array $data
     * @return $this
     */
    public function setData($data = []){

        foreach ($data as $_k=>$_v){
            $this->with($_k, $_v);
        }

        return $this;
    }

    /**
     * 获取文件路径
     * @param $viewName
     * @return string
     */
    private static function getFilePath($viewName)
    {
        $filePath = str_replace('.', '/', $viewName);
        return BASE_PATH.self::VIEW_BASE_PATH.$filePath.'.php';
    }

    /**
     * 当调用类中不存在的方法时，就会调用__call();  魔术方法
     * @param $method
     * @param $parameters
     * @return View
     */
    public function __call($method, $parameters)
    {
        if (starts_with($method, 'with'))
        {
            return $this->with(snake_case(substr($method, 4)), $parameters[0]);
        }

        throw new BadMethodCallException("方法 [$method] 不存在！.");
    }
}