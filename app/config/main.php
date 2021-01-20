<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/10/8
 * Time: 下午7:20
 */

return [
    'db'  =>  require_once APP_PATH.'/config/database.php',
    'id'   =>  'app',
    'runtimePath'   =>  '/data/runtime',
    'layout'    =>  'layout/main',
    'log'   =>  [
        'targets'  =>  [
            [
                'categories' => 'request',
                'logFile' => '@runtime/logs/request/'.date('Y').'/'.date('m').'/' . date('Y-m-d') . '.log',
            ],
            [
                'categories' => 'error',
                'logFile' => '@runtime/logs/error/'.date('Y').'/'.date('m').'/' . date('Y-m-d') . '.log',
            ],
        ]
    ],
];