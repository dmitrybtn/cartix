<?php

$config = \yii\helpers\ArrayHelper::merge(require __DIR__ . '/base.php', [

    'controllerNamespace' => 'app\commands',

    'components' => [
        'db' => require __DIR__ . '/db.php',
    ],

]);

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;

