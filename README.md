# TinySwoole

这是一个很简单的基于swoole的http框架，主要实现了基础的`swoole_http_server`的功能以及监听`TCP`、`UDP`端口。
为了让使用者了解如何使用swoole、学习如何与swoole结合框架使用以及与swoole编程与之前的fpm编程的区别。内置easywechat,
mysql断线重连特性，助力生产服务。

框架的结构很简单，核心文件在`Core`文件夹下。
- Framework 框架的核心文件，包括处理 Http 相关请求类，基础类等等
- Swoole swoole事件触发后对应的处理
- IO 处理IO
- Util 一些常用的工具
    - mysqli
    - log


## 相关命令

|操作|介绍|
|-|-|
|php index.php start|启动|
|php index.php stop|关闭|
|php index.php reload|重启|
|php index.php status|查看服务器状态|
|php index.php --help|显示帮助命令|

## 使用

如果想要使用多端口监听`tcp`、`udp`，需要在配置文件中将`multi_port`设置为`true`,并在`tcp`或者`udp`的`open`选项中设置为`true`开启。<br />

|server|port|open|
|-|-|-|
|http|9519|true|
|tcp|9520|true|
|udp|9521|true|

### Web路由 

|路由|对应文件|方法名|
|-|-|-|
|`http://127.0.0.1:9519/index/benchmark`|`App\Controller\Http\IndexController.php`|`benchmark()`|

其中，并且类文件的方法需要为公开的方法（public function）并且类需要继承`App\Http\Controller`

### HTML模版引擎

支持HTML模版，需要将控制器继承`Core\Framework\ViewController`,然后在`App`目录下新建`View`
因为本框架现仅支持2级路由，所以`View`的下一级目录则为控制器的小写名称，然后此目录下则为某方法对应的view视图

|路由|对应视图文件|
|-|-|
|`http://127.0.0.1:9519/demo/template`|`App\Http\View\demo\template.php`|

如果对应的视图找不到则会显示404页面，404页面默认在`Public`目录下

### Mysql

内置mysqli,并实现相应的断线重连。使用方法：
```
use Core\Uti\DB\Mysqli;

Mysqli::getInstance()->query('show tables')->fetchall();

# debug
Mysqli::getInstance()->setDebug(true)->query('show tables')->printDebug();
```

### Swoole相关内置函数使用

详情见`App\Controller\DemoController`这个类，demo包括下列方法的使用
- swoole_task
- swoole_timer_tick
- swoole_timer_clear
- swoole_timer_after
- tcp_client
- udp_client
- mysqli
- get/post参数接收

### 配置文件

配置文件在Config文件夹中。获取配置文件示例：<br />
`$serverConfig = Config::getInstance()->getConfig('config.server');`<br />
其中，config为Config下的config.php文件

#### 生产与开发配置分离
为了线上配置与开发配置便于管理，防止开发的配置文件用于生产环境，您可以在根目录创建一个`.env`文件，在其中写相应的配置，然后再在`Config\config.php`中使用`Core\Uti\Tools\Tools::getInstance()->getEnv('KEY')`获取`KEY`的配置(请看`.env_sample`示例)。

### Wechat 微信

支持EasyWechat

### 静态文件

静态文件在Public目录下（暂时需要配合nginx处理静态资源）

### Nginx配置域名

```
server {
    listen       80;
    server_name your.server.name;
    root to/your/path/TinySwoole/Public/;
    
    if ( $uri = "/" ) {
       rewrite ^(.*)$ /index last;
    }
    
    location / {
        proxy_http_version 1.1;
        proxy_set_header Connection "keep-alive";
        proxy_set_header X-Real-IP $remote_addr;
        # 判断文件是否存在，如果不存在，代理给Swoole
        if (!-e $request_filename){
            proxy_pass http://127.0.0.1:9519;
        }
    }
}
```

### 性能

机器: CPU: i5, RAM: 8G, OS: maxOS Sierra 10.12.6

性能报告 <br />
![image](https://github.com/zmisgod/TinySwoole/blob/master/Public/github_readme_pic/v3.png)

<br />
历史性能报告截图在`/Public/github_readme_pic`下，可以查看下每次更新性能提高多少，也可以见正我对框架做的努力。

### 关于swoole

<a href="https://wiki.swoole.com/">Swoole文档</a> <br />
swoole默认端口是`9501`，为什么是`9501`呢，答案是：九五至尊`95`+`01`（01就不用解释了吧）。

### 关于我

<a href="https://zmis.me/">zmis.me新博客</a><br />
<a href="https://weibo.com/zmisgod">@zmisgod</a>
