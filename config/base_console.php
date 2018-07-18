<?php

$config = \yii\helpers\ArrayHelper::merge(require __DIR__ . '/base.php', [

    'controllerNamespace' => 'app\commands',

    'controllerMap' => [
        'deploy' => [
            'class' => 'app\commands\DeployController',

			'username' => 'u0495829',
			'host' => 'dbtn.ru',
			'path' => '/var/www/u0495829/public_html/cartix.dbtn.ru',
			'exclude' => [
				'.git/',
				'.DS_Store',
				'/config/db.php',
				'/runtime/*',
				'/web/assets/*',
				'/web/uploads/*',
				'/web/index.php',	
                '/yii',	
			],
        ],
    ],

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

