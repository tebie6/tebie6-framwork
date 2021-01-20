<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2020/11/23
 * Time: 7:28 PM
 */

namespace services\ted\Db;
use \PDO;

/**
 * 数据库连接类
 * Class Connector
 * @package services\ted\Db
 */
class Connector{


    public $settings;
    public $pdo;

    public static $connPool = [];   // 链接池


    public function __construct($host, $port, $user, $password, $dbName, $charset = 'utf8')
    {
        $this->settings = [
            'host' => $host,
            'port' => $port,
            'user' => $user,
            'password' => $password,
            'dbname' => $dbName,
            'charset' => $charset
        ];
    }

    /**
     * 创建 PDO 实例
     * @param string $name
     * @param array $options The array options
     * @return $db
     */
    protected function connect($name, $options=[])
    {
        $dsn = 'mysql:dbname={dbname};host={host};port={port}';
        $options = [
            // 请求一个持久连接，而非创建一个新连接。关于此属性的更多信息请参见 连接与连接管理 。
            PDO::ATTR_PERSISTENT=>true,
            // 连接到MySQL服务器时执行的命令。将在重新连接时自动重新执行。
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            // 控制sql执行出错时的行为表现 PDO::ERRMODE_EXCEPTION 抛出异常
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
            // 提取的时候将数值转换为字符串。
            PDO::ATTR_STRINGIFY_FETCHES=>false,
            // 启用或禁用预处理语句的模拟。
            PDO::ATTR_EMULATE_PREPARES=>false
        ];
        $db = new PDO($dsn, $this->settings["user"], $this->settings["password"], $options);
        $db = $this->setPdoOptions($db, $options);
        return $db;
    }

    /**
     * Set the PDO options
     * @param object $instance
     * @param array $options
     */
    public function setPdoOptions($instance, array $options)
    {
        foreach ($options as $key => $item) {
            $instance->setAttribute($key, $item);
        }
        return $instance;
    }

    /**
     * Create a DB connection
     * @param string $name
     */
    public function createConn($name='default')
    {
        self::$connPool[$name] = $this->connect($name);
    }

    /**
     * Get db instance
     * @param string $name
     * @return object
     */
    public function getDB($name='default')
    {
        if($name=='') {
            throw new \Exception("The db name cannot be empty", 12911);
        }
        if(isset(self::$connPool[$name])) {
            return self::$connPool[$name];
        }
    }

    /**
     * close db conn
     * @param string $name The db link name
     */
    public function closeConnection($name)
    {
        if(isset(self::$connPool[$name])) {
            self::$connPool[$name] = null;
        }
    }
}