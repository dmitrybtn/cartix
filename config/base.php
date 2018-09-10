<?php

return \yii\helpers\ArrayHelper::merge(require __DIR__ . '/../vendor/dmitrybtn/yii2-cp/config.php', [

    'id' => 'ph-cartix',
    'name' => 'Техкарты МГИ',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'card/index',
    'bootstrap' => ['log'],
    'language' => 'ru-RU',

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
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
                        'card/view|view-images|view-text',
                    ]
                ],

                'user' => [
                    'name' => 'Пользователь',
                    'parent' => 'guest',
                    'rights' => [
                        'site|crud|sort/*',

                        'users/profile|login/*',
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

                'card/<id_mode>' => 'card/list/index',
                'card/<id_mode>/<id_card>/<controller>/<action>' => 'card/<controller>/<action>',
            ],
        ],
    ],
    'modules' => [
        'users' => [
            'class' => 'dmitrybtn\cp\users\Users',
        ],
    ]
]);


