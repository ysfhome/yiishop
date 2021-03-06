<?php

$params = require(__DIR__ . '/params.php');
$adminmenu = require(__DIR__ . '/adminmenu.php');

$config = [
    'id'           => 'basic',
    'language'     => 'zh-CN',
    'charset'      => 'utf-8',
    'defaultRoute' => 'index',//修改默认控制器为前台index控制器
    'basePath'     => dirname(__DIR__),//项目根目录
    'timeZone'     => 'Asia/Chongqing',//设置当前时区为北京时间
    'bootstrap'    => ['log'],
    'components'   => [
        'request'      => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey'  => 'pdNrTOsrTVlnSGcRBU-kQc75sSpRVjJq',
            // Enable Yii Validate CSRF Token
            'enableCsrfValidation' => true,
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        /**
         * RBAC
         */
        'authManager' => [
            'class' => 'yii\rbac\DbManager',//要使用的管理类
            'itemTable' => '{{%auth_item}}',//(这样写可以指定要使用的表,其他3个也一样,表前缀是在db.php文件配置的)
            'defaultRoles' => ['default'],//当登入用户没有任何角色时,自动拥有该角色
        ],
        /**
         * 前台用户组件
         */
        'user'         => [
            'identityClass'   => 'app\models\User',
            'identityCookie' => ['name' => '_user_identity', 'httpOnly' => true],
            'idParam' => '__user_id',
            'enableAutoLogin' => true,
            'loginUrl' => ['/member/auth'],//默认登入页
        ],
        /**
         * 后台用户组件
         */
        'admin'         => [
            'class' => 'yii\web\user',
            'identityClass'   => 'app\admin\models\admin',
            'identityCookie' => ['name' => '_admin_identity', 'httpOnly' => true],
            'idParam' => '__admin_id',
            'enableAutoLogin' => true,
            'loginUrl' => ['admin/public/login'],//后台默认登入页
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '192.168.2.200',
            'port' => 6379,
            'database' => 0,
        ],
        /* 邮件发送设置 */
        'mailer'       => [
            'class'            => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false, //必须改为false,true只是生成邮件在runtime文件夹下，不发邮件
            'transport'        => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.163.com',
                'username'   => 'zangsilu@163.com',
                'password'   => 'zsl13586722',
                'port'       => '465',//端口25对应tls协议 端口465对应ssl协议
                'encryption' => 'ssl',
            ],
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'           => require(__DIR__ . '/db.php'),
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
//            'suffix' => '.html',
            'rules'           => [
                // ...
            ],
        ],
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                ['http_address' => '127.0.0.1:9200'],
                // configure more hosts if you have a cluster
            ],
        ],
    ],
    'params'       => \yii\helpers\ArrayHelper::merge($params,['adminmenu'=>$adminmenu]),
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
//        'allowedIPs' => ['192.168.2.101'],
    ];

    //开启新创建的后台(admin)模块
    $config['modules']['admin'] = [
        'class' => 'app\admin\admin',
    ];
}

return $config;
