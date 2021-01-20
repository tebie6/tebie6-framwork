<?php

namespace services\ted\Db;

/**
 * Class Model
 * @package Ted\Db
 * @method mixed c()
 */
class Model
{

    public static $_tableName;

    public static function db($trans = false){
        if ($trans !== false) {
            DbPool::getDB($trans);
        } else {
            return DbPool::createDbConn();
        }
    }
}