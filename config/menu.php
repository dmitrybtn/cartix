<?php

use app\modules\cards\controllers\CardController;

return [
	['label' => 'Главное меню'],
	
	['label' => CardController::modes['my'], 'url' => ['/cards/card/index', 'id_mode' => 'my']],	
	['label' => CardController::modes['subscr'], 'url' => ['/cards/card/index', 'id_mode' => 'subscr']],	
	['label' => CardController::modes['common'], 'url' => ['/cards/card/index', 'id_mode' => 'common']],	

	['label' => 'Администрирование', 'visible' => Yii::$app->user->can('users/user')],
	['label' => 'Учетные записи', 'url' => ['/users/user/index'], 'active' => '/users/user/*'],	
	['label' => 'Все техкарты', 'url' => ['/logs/cards']],	
	['label' => 'Логи', 'url' => ['/logs/logs']],	

];
