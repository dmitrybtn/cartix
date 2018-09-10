<?php

return [
	['label' => 'Главное меню'],
	
	['label' => 'Мои техкарты', 'url' => ['/cards/index', 'id_mode' => 'my']],	
	['label' => 'Мои подписки', 'url' => ['/cards/index', 'id_mode' => 'subscr']],	
	['label' => 'Общие', 'url' => ['/cards/index', 'id_mode' => 'common']],	

	['label' => 'Учетные записи', 'url' => ['/users/user/index'], 'active' => '/users/user/*'],	
];
