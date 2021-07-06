<?php

namespace common\components\noahbuscher\macaw;

/**
 * @method static Macaw get(string $route, Callable $callback)
 * @method static Macaw post(string $route, Callable $callback)
 * @method static Macaw put(string $route, Callable $callback)
 * @method static Macaw delete(string $route, Callable $callback)
 * @method static Macaw options(string $route, Callable $callback)
 * @method static Macaw head(string $route, Callable $callback)
 */
class Macaw
{

    public static $halts = false;       // 停止标识
    public static $routes = array();    // 设置的伪静态路由规格
    public static $methods = array();   // 路由规格的请求方式
    public static $callbacks = array(); // 路由规格对应的回调
    public static $maps = array();
    public static $patterns = array(    // 匹配正则
        ':any' => '[^/]+',
        ':num' => '[0-9]+',
        ':all' => '.*'
    );
    public static $error_callback;
    public static $controller = array();
    public static $init = false;

    /**
     * Defines a route w/ callback and method
     */
    public static function __callstatic($method, $params)
    {
        if (self::$init) return;

        if ($method == 'map') {
            $maps = array_map('strtoupper', $params[0]);
            $uri = strpos($params[1], '/') === 0 ? $params[1] : '/' . $params[1];
            $callback = $params[2];
        } else {
            $maps = null;
            $uri = strpos($params[0], '/') === 0 ? $params[0] : '/' . $params[0];
            $callback = $params[1];
        }

        array_push(self::$maps, $maps);
        array_push(self::$routes, $uri);
        array_push(self::$methods, strtoupper($method));
        array_push(self::$callbacks, $callback);
    }

    /**
     * 没有匹配到方法的回调
     */
    public static function error($callback)
    {
        self::$error_callback = $callback;
    }

    /**
     * 暂停匹配
     * @param bool $flag
     */
    public static function haltOnMatch($flag = true)
    {
        self::$halts = $flag;
    }

    /**
     * 记录日志
     * @param string $text
     */
    public static function log($text = ''){
        @file_put_contents("/logs/routes_error.log", "\n".$text."\n", FILE_APPEND);
    }

    /**
     * 运行给定请求的回调
     * Runs the callback for the given request
     */
    public static function dispatch()
    {
        // 防止重复添加配置 消耗内存
        self::$init = true;

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        $searches = array_keys(static::$patterns);
        $replaces = array_values(static::$patterns);

        // 是否找到路由
        $found_route = false;

        // 删除多余 / 符号
        $uri = preg_replace('/\/+/', '/', $uri);
        self::$routes = preg_replace('/\/+/', '/', self::$routes);

        // 检查请求路由是否在定义的路由列表中
        if (in_array($uri, self::$routes)) {
            $route_pos = array_keys(self::$routes, $uri);
            foreach ($route_pos as $route) {


                // Using an ANY option to match both GET and POST requests
                if (self::$methods[$route] == $method || self::$methods[$route] == 'ANY' || (is_array(self::$maps[$route]) && in_array($method, self::$maps[$route]))) {
                    $found_route = true;

//                    echo "<pre>";
//                    print_r(self::$callbacks);die;
                    // If route is not an object
                    if (!is_object(self::$callbacks[$route])) {

                        // Grab all parts based on a / separator
                        $parts = explode('/', self::$callbacks[$route]);

                        // Collect the last index of the array
                        $last = end($parts);

                        // Grab the controller name and method call
                        $segments = explode('@', $last);

                        // Instanitate controller
                        if (isset(self::$controller[$segments[0]])){
                            $controller = self::$controller[$segments[0]];
                        } else {
                            $controller = self::$controller[$segments[0]]=  new $segments[0]();
                        }

                        //处理function 名称
                        $segments[1] = explode('-',$segments[1]);
                        array_walk($segments[1],function(&$v,$k){$v = ucwords($v);});
                        $segments[1] = 'action'.implode('',$segments[1]);

                        // Call method
                        $response = $controller->{$segments[1]}();
                        if(is_string($response)){
                            echo $response;
                        }

                        if (self::$halts) return;
                    } else {
                        // Call closure
                        call_user_func(self::$callbacks[$route]);

                        if (self::$halts) return;
                    }
                }
            }
        }
        else
        {
            // 检查是否用正则表达式定义
            $pos = 0;
            foreach (self::$routes as $route) {

                // 检查是否有需要匹配内容
                if (strpos($route, ':') !== false) {
                    $route = str_replace($searches, $replaces, $route);
                }

                // 获取正则配的内容
                if (preg_match('#^' . $route . '$#', $uri, $matched)) {

                    // 遍历路由列表 self::$routes 判断是否有符合条件的路由
                    if (self::$methods[$pos] == $method || self::$methods[$pos] == 'ANY' || (!empty(self::$maps[$pos]) && in_array($method, self::$maps[$pos]))) {
                        $found_route = true;

                        // 删除 $matched[0] 因为 [1] 是第一个参数
                        array_shift($matched);

                        // 判断回调内容是否为对象
                        if (!is_object(self::$callbacks[$pos])) {

                            // 根据 / 分割定义的回调内容
                            $parts = explode('/', self::$callbacks[$pos]);

                            // 获取 $parts 最后一个索引内容
                            $last = end($parts);

                            // 获取控制器名称和调用方法
                            $segments = explode('@', $last);

                            // 防止 controller 重复实例化
                            if (isset(self::$controller[$segments[0]])){
                                $controller = self::$controller[$segments[0]];
                            } else {
                                $controller = self::$controller[$segments[0]]=  new $segments[0]();
                            }

                            //处理function 名称
                            $segments[1] = explode('-',$segments[1]);
                            array_walk($segments[1],function(&$v,$k){$v = ucwords($v);});
                            $segments[1] = 'action'.implode('',$segments[1]);

                            // 判断方法是否存在
                            if (!method_exists($controller, $segments[1])) {
                                self::log("controller and action not found " . json_encode($segments));
                                echo "controller and action not found";
                            } else {
                                //  解决多参数
                                echo call_user_func_array(array($controller, $segments[1]), $matched);
                            }

                            if (self::$halts) return;
                        } else {
                            echo call_user_func_array(self::$callbacks[$pos], $matched);

                            if (self::$halts) return;
                        }
                    }
                }
                $pos++;
            }

            //匹配路由 通过 "/"
            $requestURI = '';
            if(isset($_SERVER['REQUEST_URI']) and trim($_SERVER['REQUEST_URI'])!='') {
                $requestURI = $_SERVER['REQUEST_URI'];
            }

            if(isset($_SERVER['QUERY_STRING']) and trim($_SERVER['QUERY_STRING'])!='') {
                $requestURI = substr($requestURI, 0, strpos($requestURI, '?'));
            }

            if(isset($requestURI[0]) and $requestURI[0]=='/') {
                $requestURI = substr($requestURI, 1);
            }

            $segments = explode('/', $requestURI);
            $segments[0] = APP_NAME.'\controllers\\'.ucfirst($segments[0]).'Controller';
            // Instanitate controller
            if (count($segments) == 2 && class_exists($segments[0])){

                if (isset(self::$controller[$segments[0]])){
                    $controller = self::$controller[$segments[0]];
                } else {
                    $controller = self::$controller[$segments[0]]=  new $segments[0]();
                }

                //处理function 名称
                $segments[1] = explode('-',$segments[1]);
                array_walk($segments[1],function(&$v,$k){$v = ucwords($v);});
                $segments[1] = 'action'.implode('',$segments[1]);

                if (method_exists($controller, $segments[1])) {
                    $response = $controller->{$segments[1]}();

                    $found_route = true;

                    if(is_string($response)){
                        echo $response;
                    }

                    if (self::$halts) return;

                } else {
                    $found_route = false;
                    self::log("method not exists" . json_encode($segments));
                }

            } else {
                $found_route = false;
                self::log("class not exists" . json_encode($segments));
            }

        }

        // Run the error callback if the route was not found
        if ($found_route == false) {

            if (!self::$error_callback) {
                self::$error_callback = function () {
                    header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found");
                    echo '404';
                };
            } else {
                if (is_string(self::$error_callback)) {
                    self::$init = false;
                    self::get($uri, self::$error_callback);
                    self::$error_callback = null;
                    self::dispatch();
                    return;
                }
            }
            call_user_func(self::$error_callback);
        }
    }
}
