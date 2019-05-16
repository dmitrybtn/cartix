<?php

namespace app\controllers;

use Yii;
use app\modules\cards\models\{Card, CardLog};

//*****************************************************************************
class LogsController extends \dmitrybtn\cp\Controller
//*****************************************************************************
{
	//-------------------------------------------------------------------------
	public static function title($actionId, $model = null)
	//-------------------------------------------------------------------------
	{
		return [
			'logs' => 'Логи',
			'cards' => 'Все техкарты',
		][$actionId];
	}

	//-------------------------------------------------------------------------
	public static function breads($actionId, $model = null)
	//-------------------------------------------------------------------------
	{
		$breads = [];

		return $breads;
	}


	//-------------------------------------------------------------------------
	public function actionLogs($ss = '')
	//-------------------------------------------------------------------------
	{
		$modLog = new CardLog(['scenario' => 'search']);
		$modLog->search_string = $ss;
		
		return $this->render('logs', ['modLog' => $modLog]);
	}


	//-------------------------------------------------------------------------
	public function actionCards($ss = '')
	//-------------------------------------------------------------------------
	{
		$modCard = new Card(['scenario' => 'search']);
		$modCard->search_string = $ss;
		
		return $this->render('cards', ['modCard' => $modCard]);
	}	

}
