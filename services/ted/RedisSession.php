<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2021/3/24
 * Time: 2:04 PM
 */
namespace services\ted;

/**
 * Redis Session管理
 * Class RedisSession
 * @package services\ted
 */
class RedisSession {

    /**
     * 连接
     * @var Redis
     */
    public $redis;

    /**
     * Key前缀
     * @var string
     */
    public $keyPrefix = 'SESSION:';

    /**
     * RedisHandler constructor.
     * @param Redis $redis
     * @param string $keyPrefix
     */
    public function __construct($redis, $keyPrefix = 'SESSION:')
    {
        $this->redis     = $redis;
        $this->keyPrefix = $keyPrefix;
    }

    /**
     * 判断 session_id 是否存在
     * @param string $sessionId
     * @return bool
     */
    public function exists($sessionId)
    {
        $key     = $this->getSaveKey($sessionId);
        $success = $this->redis->exists($key);
        return $success ? true : false;
    }

    /**
     * 更新生存时间
     * @param string $sessionId
     * @param int $maxLifetime
     * @return bool
     */
    public function expire($sessionId, $maxLifetime)
    {
        $key     = $this->getSaveKey($sessionId);
        $success = $this->redis->expire($key, $maxLifetime);
        return $success ? true : false;
    }

    /**
     * 赋值
     * @param string $sessionId
     * @param string $name
     * @param $value
     * @return bool
     */
    public function set($sessionId, $name, $value)
    {
        $key     = $this->getSaveKey($sessionId);
        $success = $this->redis->hMset($key, [$name => serialize($value)]);
        return $success ? true : false;
    }

    /**
     * 取值
     * @param string $sessionId
     * @param string $name
     * @param null $default
     * @return mixed
     */
    public function get($sessionId, $name, $default = null)
    {
        $key   = $this->getSaveKey($sessionId);
        $value = $this->redis->hGet($key, $name);
        return $value === false ? $default : unserialize($value);
    }

    /**
     * 取所有值
     * @param string $sessionId
     * @return array
     */
    public function all($sessionId)
    {
        $key    = $this->getSaveKey($sessionId);
        $result = $this->redis->hGetAll($key);
        foreach ($result as $name => $item) {
            $result[$name] = unserialize($item);
        }
        return $result ?: [];
    }

    /**
     * 删除
     * @param string $sessionId
     * @param string $name
     * @return bool
     */
    public function delete($sessionId, $name)
    {
        $key     = $this->getSaveKey($sessionId);
        $success = $this->redis->hDel($key, $name);
        return $success ? true : false;
    }

    /**
     * 清除session
     * @param string $sessionId
     * @return bool
     */
    public function clear($sessionId)
    {
        $key     = $this->getSaveKey($sessionId);
        $success = $this->redis->del($key);
        return $success ? true : false;
    }

    /**
     * 判断是否存在
     * @param string $sessionId
     * @param string $name
     * @return bool
     */
    public function has($sessionId, $name)
    {
        $key   = $this->getSaveKey($sessionId);
        $exist = $this->redis->hExists($key, $name);
        return $exist ? true : false;
    }

    /**
     * 获取保存的key
     * @param string $sessionId
     * @return string
     */
    protected function getSaveKey($sessionId)
    {
        return $this->keyPrefix . $sessionId;
    }
}

