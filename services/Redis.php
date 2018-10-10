<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/10/9
 * Time: 下午10:55
 */

namespace services;
use Predis\Client;

class Redis
{

    const CONFIG_FILE = 'config/redis.php';

    protected static $redis = null;


    /**
     * 创建 Redis连接
     * @return null|Client
     * @throws \Exception
     */
    public static function createConnect(){

        // Config 文件处理
        $file_path = APP_PATH . '/../'.self::CONFIG_FILE;
        if( !is_file($file_path) ){
            throw new \Exception('redis config file not exist.');
        }
        $config = require $file_path;

        if( self::$redis === null ){
            // 实例 Redis
            self::$redis = new Client($config);
        }

    }

    /**
     * 设置一个 key
     * @param $key
     * @param $value
     * @param null $time
     * @param null $unit    h m s ms
     */
    public static function set($key, $value, $time = null, $unit = null){

        self::createConnect();

        if ($time) {

            switch ($unit) {
                case 'h':
                    $time *= 3600;
                    break;

                case 'm':
                    $time *= 60;
                    break;

                case 's':

                case 'ms':
                    break;

                default:
                    throw new \InvalidArgumentException('单位只能是 h m s ms');
                    break;
            }

            if ($unit == 'ms') {

                self::_psetex($key, $value, $time);
            } else {

                self::_setex($key, $value, $time);
            }

        } else {

            self::$redis->set($key, $value);
        }

    }

    /**
     * 获取一个 key
     * @param $key
     * @return mixed
     */
    public static function get($key){

        self::createConnect();

        return self::$redis->get($key);
    }

    /**
     * 删除一个 key
     * @param $key
     * @return mixed
     */
    public static function delete($key){

        self::createConnect();

        return self::$redis->del($key);
    }

    // Redis Setex 命令为指定的 key 设置值及其过期时间。如果 key 已经存在， SETEX 命令将会替换旧的值。
    private static function _setex($key, $value, $time){

        self::$redis->setex($key, $time, $value);
    }

    // Redis Psetex 命令以毫秒为单位设置 key 的生存时间。
    private static function _psetex($key, $value, $time){

        self::$redis->psetex($key, $time, $value);
    }


}