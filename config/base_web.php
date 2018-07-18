<?php

$config = \yii\helpers\ArrayHelper::merge(require __DIR__ . '/base.php', [
    'components' => [
        'db' => require __DIR__ . '/db.php',

        'request' => [
            'cookieValidationKey' => '2DhAfOf8hglIJ-hxwDCQixZ6s5i6iDqo',
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
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
}

return $config;

