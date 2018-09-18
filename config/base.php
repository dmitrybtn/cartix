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
            'class' => 'dmitrybtn\cp\users\Users',
        ],        
    ],

    'components' => [

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'user' => [
            'class' => 'dmitrybtn\cp\users\components\User',
        ],

        'authManager' => [
            'class' => 'dmitrybtn\cp\users\components\UserAuth',
            'roles' => [

                'guest' => [
                    'name' => 'Гость',
                    'rights' => [
                        'users/login/login',

                        'card/one/view/*',
                    ]
                ],

                'user' => [
                    'name' => 'Пользователь',
                    'parent' => 'guest',
                    'rights' => [
                        'site/index',
                        'users/login|profile/*',

                        'card/one/*',
                        'card/list/*',
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
            'forceCopy' => true,
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

                '<module>/<controller>/<action>' => '<module>/<controller>/<action>',

                /*
                '<module:(users)>/<controller>/<action>' => '<module>/<controller>/<action>',

                'site/<action>' => 'site/<action>',

                'list/<action>' => 'card/list/<action>',
                'card/admin/<action>' => 'card/admin/<action>',

                '<id_card>' => 'card/one/view/plan',
                '<id_card>/<action>' => 'card/one/view/<action>',
                '<id_card>/<controller>/<action>' => 'card/one/<controller>/<action>',
                */

            ],
        ],
    ],

]);


