<?php

namespace console\controllers;
use services\ted\Controller;

/**
 * Class Testontroller
 * @package console\controllers
 */
class TestController extends Controller
{

    public function actionIndex(){

        echo "this is index".PHP_EOL;
    }
}