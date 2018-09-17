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

                        'cards/card/plan|text',
                        'cards/image/view',
                    ]
                ],

                'user' => [
                    'name' => 'Пользователь',
                    'parent' => 'guest',
                    'rights' => [
                        'users/login|profile/*',

                        'site/*',

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

                /*
                'cards/<action:(index|create)>' => 'cards/<action>',

                'cards/<id_card>' => 'cards/card/plan',
                'cards/<id_card>/text' => 'cards/card/text',

                [
                    'pattern' => 'cards/<id_card>/<controller>/<action>',
                    'route' => 'cards/<controller>/<action>',
                    'defaults' => [
                        'action' => 'view',
                    ],
                ],
                */



            ],
        ],
    ],
    'modules' => [
        'users' => [
            'class' => 'dmitrybtn\cp\users\Users',
        ],
    ]
]);


