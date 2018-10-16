<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/10/8
 * Time: 下午7:20
 */

return [

    'id'   =>  'app',
    'runtimePath'   =>  '/data/log',
    'layout'    =>  'layout/main',
    'log'   =>  [
        'targets'  =>  [
            [
                'categories' => ['request'],
                'logFile' => '@runtime/logs/request/'.date('Y').'/'.date('m').'/' . date('Y-m-d') . '.log',
            ],
        ]
    ],
];