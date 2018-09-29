<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/9/28
 * Time: 下午3:55
 */

use NoahBuscher\Macaw\Macaw;
Macaw::get('', 'app\controllers\HomeController@home');

Macaw::$error_callback = function() {

    throw new Exception("路由无匹配项 404 Not Found");

};

Macaw::dispatch();