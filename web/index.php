<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

function d($var, $depth = 10, $highlight = false) {
	echo '<pre>';
	\yii\helpers\VarDumper::dump($var, $depth, $highlight);
	echo '</pre>';
}

$config = require __DIR__ . '/../config/base_web.php';

(new yii\web\Application($config))->run();
