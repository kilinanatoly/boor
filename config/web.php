<?php
use developeruz\db_rbac\behaviors\AccessBehavior;

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'language' => 'ru-RU',
    'charset' => 'utf-8',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => '',
                '/admin' => '/admin/products/create',
                '/catalog/<cat:\S+>/view/<name:\S+>_<id:\d+>' => '/site/product',
                '/products/<id:\d+>' => '/site/product',
                '/catalog/<cat:\S+>_<cat_id:\d+>' => '/site/cats',
                '/videos/<url:\S+>' => '/site/video',
                '/info/<url:\S+>' => '/site/info',
                '<module:\S+>/<controller:\S+>/<action:\S+>' => '/<module>/<controller>/<action>',
                '<module:\S+>/<controller:\S+>' => '/<module>/<controller>',
                '<action:\S+>' => '/site/<action>'

            ]
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'request' => [
            'baseUrl' => '',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '12345',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,//set this property to false to send mails to real email addresses
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'rus.euroboor@gmail.com',
                'password' => 'euroboor',
                'port' => 587,
                'encryption' => 'tls',
            ],
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
        'db' => require(__DIR__ . '/db.php'),


    ],
    'params' => $params,
    'as AccessBehavior' => [
        'class' => AccessBehavior::className(),
        'rules' =>
            [
                'site' =>
                    [
                        [
                            'actions' => [],
                            'allow' => true,
                        ],

                    ],
                'ajax' =>
                    [
                        [
                            'actions' => [],
                            'allow' => true,
                        ],

                    ],
                'admin' =>
                    [
                        [
                            'actions' => [],
                            'allow' => true,
                            'roles'=>['admin']
                        ],

                    ],

            ]
    ],
    'modules' => [
        'permit' => [
            'class' => 'developeruz\db_rbac\Yii2DbRbac',
            'params' => [
                'userClass' => 'app\models\User'
            ]
        ],
        'admin' => [
            'class' => 'app\modules\admin\Admin',
        ],
    ],
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
    ];
}

return $config;
