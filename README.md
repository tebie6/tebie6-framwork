# tebie6-framwork


Build a framework that belongs to Ted.

打造一个结构清晰，操作简单的轻量化Framwork

借鉴了 Yii 中部分好用的功能

### 目录结构

    app/                 应用 （支持多应用）
    ---- config/                 配置
    ---- controllers/            控制器
    ---- models/                 模型
    ---- views/                  视图
    -------- layout/                 布局        
    ---- web/                    入口文件
    
            
    common/              公共目录
    ---- components          公共组件
    ---- config              公共配置（暂未使用）
    ---- utilty.php          工具
        
    services/            服务
    ---- ted/                核心文件
    ---- app/                app应用所属服务
    -------- start.php           workerman 服务启动文件
    -------- start_web.php       webServer 常驻脚本
    
            
    bootstrap.php        启动器
    composer.json        composer配置




### 使用方式

#### 1、多应用开发
    
    将app初始应用复制 在入口文件 修改 APP_NAME 即可
    例子：   app/
            testApplication/
    
#### 2、PHP常驻内存方式运行

    将 services/app 目录复制 修改 APP_NAME 即可
    例子：   services/app/start.php
            services/test/start.php
            
#### 3、数据库操作
    
    使用 Workerman支持的 Mysql数据库操作类
    
    全局 Ted::$app->db 全局唯一连接
    Model内 self::db() 每次实例创建一个连接
    
    详情查看 common\components\workerman\mysql\Connection

      
### 4、Workerman
    
    请参考官方文档
    worker 服务编写位置  services/应用名/start_*.php
    执行 start.php 会自动执行 services/应用名/  下所有 start_*.php服务
    
### 5、参数获取

    Ted::$app->request->get();
    或
    Ted::$app->request->post();
    
    参数 1 获取的key name    function(key_name)
    参数 2 默认值            function(key_name, default_value)
    
### 6、视图加载

    渲染布局
    $this->render($viewName, $data = []);
    
    不渲染布局
    $this->renderPartial($viewName, $data = []);
    
    视图中块加载
    $this->beginBlock(块名称);
    $this->endBlock(块名称);
    
### 7、Redis
    
    Ted::$app->redis
 
### 8、Session

    Ted::$app->session->get();
    Ted::$app->session->set();
    
### 9、开发辅助
    
    sh ./services/fswatch.sh /需要监听的目录
    例：sh ./services/fswatch.sh /project/tebie6-framework
   
### 性能

测试环境：Workerman version:3.5.13

PHP version:7.4.7

性能测试：1核 1G 并发100 连接10000次

RPS能达到 950左右 内存没有明显的增加
    
    Server Software:        workerman/3.5.13
    Server Hostname:        127.0.0.1
    Server Port:            8080
    
    Document Path:          /
    Document Length:        1 bytes
    
    Concurrency Level:      100
    Time taken for tests:   10.103 seconds
    Complete requests:      10000
    Failed requests:        0
    Write errors:           0
    Keep-Alive requests:    10000
    Total transferred:      1280000 bytes
    HTML transferred:       10000 bytes
    Requests per second:    989.85 [#/sec] (mean)
    Time per request:       101.026 [ms] (mean)
    Time per request:       1.010 [ms] (mean, across all concurrent requests)
    Transfer rate:          123.73 [Kbytes/sec] received
    
    Connection Times (ms)
                  min  mean[+/-sd] median   max
    Connect:        0    0   0.4      0       7
    Processing:     2  100  15.0     96     312
    Waiting:        2  100  15.0     96     312
    Total:          2  100  14.8     96     312
    
    Percentage of the requests served within a certain time (ms)
      50%     96
      66%     98
      75%    100
      80%    102
      90%    111
      95%    123
      98%    154
      99%    177
     100%    312 (longest request)
     
     
     ----------------------------------------------GLOBAL STATUS----------------------------------------------------
     Workerman version:3.5.13          PHP version:7.4.7
     start time:2021-01-20 17:47:58   run 0 days 0 hours
     load average: 0.42, 0, 0         event-loop:\common\components\workerman\Events\Event
     1 workers       1 processes
     worker_name  exit_status      exit_count
     WebServer    0                0
     ----------------------------------------------PROCESS STATUS---------------------------------------------------
     pid	memory  listening           worker_name  connections send_fail timers  total_request qps    status
     39970	4M      http://0.0.0.0:8080 WebServer    0           0         0       20000         0      [idle]
     ----------------------------------------------PROCESS STATUS---------------------------------------------------
     Summary	4M      -                   -            0           0         0       20000         0      [Summary]

### 备注

   1、框架核心代码目前比较混乱 后期将逐步优化
   
   2、PHP常驻内存运行方式 内存管理后期将逐步优化
   
   3、mysql连接池 后期将逐步优化
   
    未完待续。。。

