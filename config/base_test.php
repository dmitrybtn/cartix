<?php

$config = \yii\helpers\ArrayHelper::merge(require __DIR__ . '/base.php', [
    'components' => [
        'db' => require __DIR__ . '/db_test.php',

        'mailer' => [
            'useFileTransport' => true,
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],

        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,            
        ],        
    ],
]);


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
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;

