<?php

return \yii\helpers\ArrayHelper::merge(require __DIR__ . '/../vendor/dmitrybtn/yii2-cp/config.php', [

    'id' => 'ph-cartix',
    'name' => 'Техкарты МГИ',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'site/index',
    'bootstrap' => ['log'],
    'language' => 'ru-RU',

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],

    'modules' => [
        'cards' => [
            'class' => 'app\modules\cards\Cards',
        ],

        'users' => [
            'class' => 'app\modules\users\Users',
        ],        
    ],

    'components' => [

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'user' => [
            'class' => 'app\modules\users\components\User',
        ],

        'authManager' => [
            'class' => 'app\modules\users\components\UserAuth',
            'roles' => [

                'guest' => [
                    'name' => 'Гость',
                    'rights' => [
                        'users/login/login',

                        'cards/one/view/*',
                    ]
                ],

                'user' => [
                    'name' => 'Пользователь',
                    'parent' => 'guest',
                    'rights' => [
                        'site/index',
                        'users/login|profile/*',

                        'cards/one/*',
                        'cards/list/*',
                    ]
                ],

                'admin' => [
                    'name' => 'Администратор',
                    'parent' => 'user',
                    'rights' => [

                    ]
                ],


                'root' => [
                    'name' => 'Разработчик',
                ],
            ]            
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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

        'assetManager' => [
            'forceCopy' => false,
            'appendTimestamp' => true,
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'normalizer' => [
                'class' => 'yii\web\UrlNormalizer',
            ],           
            'rules' => [

                'site/<action>' => 'site/<action>',
                'list/<action>' => 'cards/list/<action>',

                '<module:(users|cards)>/<controller>/<action>' => '<module>/<controller>/<action>',

                '<id_card>' => 'cards/one/view/plan',
                '<id_card>/<action>' => 'cards/one/view/<action>',
                '<id_card>/<controller>/<action>' => 'cards/one/<controller>/<action>',

            ],
        ],
    ],

]);


