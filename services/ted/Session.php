<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2021/3/24
 * Time: 2:04 PM
 */
namespace services\ted;
use common\components\workerman\Protocols\Http;

/**
 * Session管理类
 * Class Session
 * @package services\ted
 * @property \services\ted\RedisSession $redis_session
 */

class Session {

    protected $session_id = null;
    protected $redis_session = null;

    /**
     * 获取session_id
     * @return string
     */
    public function getId()
    {
        return $this->session_id;
    }

    /**
     * 创建session_id
     * @return string
     */
    protected function createId()
    {
        do {
            $sessionId = static::randomAlphanumeric(26);
        } while ($this->redis_session->exists($sessionId));
        return $sessionId;
    }

    /**
     * 获取随机字符
     * @param $length
     * @return string
     */
    protected static function randomAlphanumeric($length)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        $last  = 61;
        $str   = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[mt_rand(0, $last)];
        }
        return $str;
    }

    /**
     * 开启session
     * @param $redis
     */
    public function open($redis)
    {
        // 初始化redis session
        if ($this->redis_session == null){
            $this->redis_session = new RedisSession($redis);
        }

        // 获取sessionid
        if (isset($_COOKIE['PHPSESSIONID']) && !empty($_COOKIE['PHPSESSIONID'])){
            $this->session_id = $_COOKIE['PHPSESSIONID'];
        } else {
            $this->session_id = $this->createId();
        }

        Http::header("Set-Cookie:PHPSESSIONID=". $this->session_id);
    }

    /**
     * 获取Session
     * @param $key
     * @param null $defaultValue
     * @return null
     */
    public function get($key, $defaultValue = null)
    {
        return $this->redis_session->get($this->getId(), $key, $defaultValue);
    }

    /**
     * 设置Session
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->redis_session->set($this->getId(), $key, $value);
    }


}//类定义结束
