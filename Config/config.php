<?php
return [
    'mysqli' => [
        'host' => Core\Uti\Tools\Tools::getInstance()->getEnv('MYSQL_HOTS'),
        'user' => Core\Uti\Tools\Tools::getInstance()->getEnv('MYSQL_USERNAME'),
        'password' => Core\Uti\Tools\Tools::getInstance()->getEnv('MYSQL_PASSWORD'),
        'port' => Core\Uti\Tools\Tools::getInstance()->getEnv('MYSQL_PORT'),
        'charset' => Core\Uti\Tools\Tools::getInstance()->getEnv('MYSQL_CHARSET'),
        'database' => Core\Uti\Tools\Tools::getInstance()->getEnv('MYSQL_DATABASE'),
    ],
    'wechat' => [
        'app_id'    => Core\Uti\Tools\Tools::getInstance()->getEnv('WECHAT_APP_ID'),
        'secret'    => Core\Uti\Tools\Tools::getInstance()->getEnv('WECHAT_SECRET'),
        'token'     => Core\Uti\Tools\Tools::getInstance()->getEnv('WECHAT_TOKEN'),
        'log' => [
            'level' => 'debug',
            'file'  => ROOT . 'Log/easywechat.log',
        ],
    ],
    'framework' => [
        'debug' => false,
        'log_folder' => ROOT. 'Log/Debug/'
    ],
    'server' => [
        'host' => '127.0.0.1',
        'port' => 9519,
        'server_type' => \Core\Swoole\Server::SERVER_TYPE_WEB,
        'socket_type' => SWOOLE_SOCK_TCP,
        "mode" => SWOOLE_PROCESS,//不建议更改此项
        'setting' => [
            'daemonize' => true,
            'open_http_protocol' => true,
            'task_worker_num' => 1, //异步任务进程
            "task_max_request" => 10,
            'max_request' => 5000,//强烈建议设置此配置项
            'worker_num' => 4,
            'log_file' => ROOT . "/Log/Server/swoole.log",
            'pid_file' => ROOT . "/Log/Server/pid.pid",
        ],
        //是否开启多端口监听
        'multi_port' => true,
        'multi_port_settings' => [
            'tcp' => [
                'open' => true,//是否开启tcp
                'type' => \Core\Swoole\Server::LISTEN_PORT_TCP, //端口类型
                'port' => 9520,
                'socket_type' => SWOOLE_TCP,
                'setting' => [
                    "open_eof_check"=>false,
                    "package_max_length"=>2048,
                ]
            ],
            'udp' => [
                'open' => true,//是否开启udp
                'type' => \Core\Swoole\Server::LISTEN_PORT_UDP,//端口类型
                'port' => 9521,
                'socket_type' => SWOOLE_UDP,
                'setting' => [
                    "open_eof_check"=>false,
                    "package_max_length"=>2048,
                ]
            ]
        ]
    ]
];