<?php

namespace services\ted\Db;
use common\components\workerman\mysql\TestConnection;

/**
 * Class Model
 * @package Ted\Db
 */
class Model
{

    public static $_tableName;

    public static function db($trans = false){

        if ($trans == false){
            $trans = TestDbPool::trxid();
        }
        $orm = new TestConnection($trans);
        return $orm;
//        $trans = 'default';
//        if ($trans !== false) {
//            return DbPool::getDB($trans);
//        } else {
//            return DbPool::createDbConn();
//        }
    }
}