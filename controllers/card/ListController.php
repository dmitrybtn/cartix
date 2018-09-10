<?php

namespace app\controllers\card;

use Yii;

use app\models\Card;

//*****************************************************************************
class ListController extends BaseController
//*****************************************************************************
{






	//-------------------------------------------------------------------------
	public function actionIndex($ss = '')
	//-------------------------------------------------------------------------
	{
		$modCard = new Card(['scenario' => 'search']);
		$modCard->search_string = $ss;

		$this->title = BaseController::mode($this->id_mode);
		$this->breads = [];

		$this->menu = [
			['label' => 'Опции'],
			['label' => self::title('create'), 'url' => ['create']],
		];
		
		return $this->render('@app/views/card/list.php', ['modCard' => $modCard]);
	}
}
