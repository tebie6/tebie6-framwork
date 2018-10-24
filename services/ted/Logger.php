<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/10/15
 * Time: 下午3:29
 */

namespace services\ted;

// Log 日志写入类
class Logger
{

    // 日志消息等级
    const EMERGENCY = LOG_EMERG;    // 0
    const ALERT     = LOG_ALERT;    // 1
    const CRITICAL  = LOG_CRIT;     // 2
    const ERROR     = LOG_ERR;      // 3
    const WARNING   = LOG_WARNING;  // 4
    const NOTICE    = LOG_NOTICE;   // 5
    const INFO      = LOG_INFO;     // 6
    const STRACE    = 7;
    const DEBUG     = 8;

    // 文件后缀
    const FILE_EXT = '.log';

    /**
     * @var  string  保存日志的目录
     */
    protected $_directory;

    /**
     * @var  string  日志记录时间的格式
     */
    public static $timestamp = 'Y-m-d H:i:s';

    /**
     * @var  array  日志消息数组
     */
    protected $_messages = [];

    /**
     * 获取log路径
     * @param $category
     * @return mixed
     * @throws \Exception
     */
    public function getDirectory($category){

        // 获取应用配置文件
        $config = require APP_PATH.DIRECTORY_SEPARATOR.'config/main.php';
        if(!isset($config['runtimePath']) || empty($config['runtimePath'])){
            $config['runtimePath'] = dirname(__DIR__).DIRECTORY_SEPARATOR.APP_NAME.DIRECTORY_SEPARATOR.'log/';
        }

        $logConfig = [];
        if(isset($config['log']['targets']) && is_array($config['log']['targets'])){
            foreach ($config['log']['targets'] as $_k=>$_v){
                $logConfig[$_v['categories']] = $_v;
            }
        }


        if(!isset($logConfig[$category])){
            throw new \Exception("'{$category}' log config not found");
        }

        if(!isset($logConfig[$category]['logFile'])){
            throw new \Exception("'{$category}' -> logFile params not found");
        }

        return str_replace('@runtime',$config['runtimePath'],$logConfig[$category]['logFile']);
    }

    public function info($message, $category){

        $directory = $this->getDirectory($category);
        $this->add($directory, LOG_INFO, var_export($message, true));
    }

    public function error($message, $category){

        $directory = $this->getDirectory($category);
        $message = [
            '_server'   =>  $_SERVER,
            'error_message' =>  $message,
        ];

        $this->add($directory, LOG_ERR, var_export($message, true));
    }

    /**
     * 添加一组日志信息到日志对象中
     *
     *     $log->add(Log::ERROR, 'Could not locate user: :user', array(
     *         ':user' => $username,
     *     ));
     *
     * @param   string  日志存放目录
     * @param   string  这组日志对象的错误等级
     * @param   string  日志消息
     * @param 	array 	记录错误位置信息
     *
     * 		array('file'=>__FILE__,'line'=>'__LINE__');
     *
     * @return  Log
     */
    public function add($directory, $level, $message, array $additional=null) {
        // Create a new message and timestamp it
        $this->_messages[] = array (
            'time'  => date(self::$timestamp, time()),
            'level' => $level,
            'body'  => $message,
            'file'	=> isset($additional['file']) ? $additional['file'] : NULL,
            'line'	=> isset($additional['line']) ? $additional['line'] : NULL,
        );

        $this->write($directory, $this->_messages);
    }

    /**
     * 将messages数组中的每一组日志信息存储到文件中，格式为/YYYY/MM/DD.php
     * example:2014/11/18.php 表示2014年11月18日的日志文件
     *
     * @param $directory
     * @param array $messages
     * @throws \Exception
     */
    private function write($directory, array $messages)
    {

        $directory = pathinfo($directory);
        $filename = $directory['dirname'] . DIRECTORY_SEPARATOR . $directory['basename'];
        $directory = $directory['dirname'];

        // 检测目录
        if (!is_dir($directory) || !is_writable($directory)) {
            try {
                mkdir($directory, 0777, true);
                chmod($directory, 0755);
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage(), $e->getFile());
            }
        }

        // 要写入的文件
        if (!file_exists($filename)) {
            // 如果不存在日志文件，创建，并在记录日志开始写入安全验证程序
            file_put_contents($filename, '' . PHP_EOL);
            // 设置文件权限为所有用户可读可写
            chmod($filename, 0666);
        }
        foreach ($messages as $message) {
            // 循环日志写信数组，写入每一条日志
            file_put_contents($filename, PHP_EOL . PHP_EOL . PHP_EOL . $message['time'] . ' --- level:' . $message['level'] . ': ' . PHP_EOL . $message['body'] . PHP_EOL . '		[at file]:' . $message['file'] . '		[at line]:' . $message['line'], FILE_APPEND);
        }

    }
}