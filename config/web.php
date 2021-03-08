<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        /*'session' => [
            //'class' => 'app\models\Session',
            'class' => 'yii\web\DbSession',
            'db' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=localhost;dbname=cms',
                'username' => 'root',
                'password' => '',
                
            ],  // the application component ID of the DB connection. Defaults to 'db'.
            'sessionTable' => 'session', // session table name. Defaults to 'session'.
            
            'writeCallback' => function($session){
                //$user_browser = null;
                       // $browser = new \BrowserDetection();
                        //$user_browser = "{$browser->getName()}-{$browser->getPlatform()}" . ($browser->is64bitPlatform() ? "(x64)" : "(x86)") . ($browser->isMobile() ? "-Mobile" : "-Desktop");
                    
                return [
                    //'user_id' => Yii::$app->user->id
                    'user_id' => 11,
                    'last_write' => new \yii\db\Expression('NOW()'),
                    //'browser_platform' => $user_browser
                    'browser_platform' => 'chrome'
                ];
            }
             
        ],*/
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'YXrzug2zomoaVBOSlN5e86XvBwadrFzR',
        ],
       'session' => [
            'class' => 'yii\web\Session',
            'cookieParams' => ['httponly' => true, 'lifetime' => 0],
            'timeout' => 0,
        ],
         /*'session' => [
            // this is the name of the session cookie used for login on the frontend
            'class' => 'yii\web\Session',
            'name' => 'advanced-frontend',
            'timeout' => 0,
        ],*/
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.ethereal.email',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'zoie17@ethereal.email',
                'password' => 'YmCfz5fRCMUHWU4t3H',
                'port' => '587', // Port 25 is a very common port too
                'encryption' => 'tls', // It is often used, check your provider or mail server specs
            ],
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            //'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        
    ],
    'timeZone' => 'GMT',
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
