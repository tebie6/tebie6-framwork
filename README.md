# tebie6-framwork


Build a framework that belongs to Angela.

选择 Laravel 的 illuminate/database 作为我们的 ORM 包

后期将加入Yii2 部分常用功能 和 workerman

打造一个结构清晰，操作简单的Framwork

大家好 我是陆超 happy everyday 真好！

### 目录结构
<pre>
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

</pre>


### 使用方式

#### 1、多应用开发
    
    将app初始应用复制 在入口文件 修改 APP_NAME 即可
    例子：   app/
            testApplication/
    
#### 2、PHP常驻内存方式运行

    将 services/app 目录复制 修改 APP_NAME 即可
    例子：   services/app
            services/test
            
#### 3、数据库操作
    
    使用 Laravel 的 illuminate/database 作为ORM 包
    操作方式同 Laravel框架
      
### 4、Workerman
    
    请参考官方文档
    worker 服务编写位置  services/应用名/start_*.php
    执行 start.php 会自动执行 services/应用名/  下所有 start_*.php服务
    
### 5、参数获取

    Fuck::$app->request->get();
    或
    Fuck::$app->request->post();
    
    参数 1 获取的key name    function(key_name)
    参数 2 默认值            function(key_name, default_value)

### 备注

   1、框架核心代码目前比较混乱 后期将逐步优化
   
   2、PHP常驻内存运行方式 会存在内存溢出的问题 后期将逐步优化
    
    未完待续。。。

