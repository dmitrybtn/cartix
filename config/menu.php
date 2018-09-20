<?php

use app\modules\cards\controllers\ListController;

return [
	['label' => 'Главное меню'],
	
	['label' => ListController::modes['my'], 'url' => ['/cards/list/index', 'id_mode' => 'my']],	
	['label' => ListController::modes['subscr'], 'url' => ['/cards/list/index', 'id_mode' => 'subscr']],	
	['label' => ListController::modes['common'], 'url' => ['/cards/list/index', 'id_mode' => 'common']],	

	['label' => 'Учетные записи', 'url' => ['/users/user/index'], 'active' => '/users/user/*'],	
];
