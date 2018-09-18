<?php

return [
	['label' => 'Главное меню'],
	
	['label' => 'Мои техкарты', 'url' => ['/card/list/index', 'id_mode' => 'my'], 'active' => (Yii::$app->controller->id_mode ?? '') == 'my'],	
	['label' => 'Мои подписки', 'url' => ['/card/list/index', 'id_mode' => 'subscr'], 'active' => (Yii::$app->controller->id_mode ?? '') == 'subscr'],	
	['label' => 'Общие', 'url' => ['/card/list/index', 'id_mode' => 'common'], 'active' => (Yii::$app->controller->id_mode ?? '') == 'common'],	

	['label' => 'Учетные записи', 'url' => ['/users/user/index'], 'active' => '/users/user/*'],	
];
