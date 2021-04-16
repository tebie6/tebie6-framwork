<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/10/24
 * Time: 11:40 AM
 */
namespace services\ted;

/**
 * Class Request
 * @package services\ted
 */
class Request
{

    /**
     * Returns POST parameter with a given name. If name isn't specified, returns an array of all POST parameters.
     *
     * @param string $name the parameter name
     * @param mixed $defaultValue the default parameter value if the parameter does not exist.
     * @return array|mixed
     */
    public function post($name = null, $defaultValue = null)
    {
        $params = $_POST;
        if ($name === null) {
            return $params;
        }

        return isset($params[$name]) ? $params[$name] : $defaultValue;
    }

    /**
     * Returns GET parameter with a given name. If name isn't specified, returns an array of all GET parameters.
     *
     * @param string $name the parameter name
     * @param mixed $defaultValue the default parameter value if the parameter does not exist.
     * @return array|mixed
     */
    public function get($name = null, $defaultValue = null)
    {

        $params = $_GET;
        if ($name === null) {
            return $params;
        }

        return isset($params[$name]) ? $params[$name] : $defaultValue;
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.

        throw new \Exception("Call to undefined method Request::{$name}() ");
    }
}