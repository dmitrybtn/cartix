<?php

namespace app\controllers;

use Yii;

use app\controllers\card\BaseController;
use app\models\Card;

//*****************************************************************************
class CardController extends \dmitrybtn\cp\Controller
//*****************************************************************************
{
	public $id_mode;
	public $card;


	//-------------------------------------------------------------------------
	public static function title($actionId)
	//-------------------------------------------------------------------------
	{
		return [
			'create' => 'Добавить техкарту',
		][$actionId];
	}


	//-------------------------------------------------------------------------
	public function init()
	//-------------------------------------------------------------------------
	{
		$this->id_mode = Yii::$app->request->get('id_mode');
	}

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
			['label' => self::title('create'), 'url' => ['create', 'id_mode' => $this->id_mode], 'visible' => $this->id_mode == 'my'],
		];
		
		return $this->render('@app/views/card/card/list.php', ['modCard' => $modCard]);
	}

	//-------------------------------------------------------------------------
	public function actionCreate()
	//-------------------------------------------------------------------------
	{
		$this->card = new Card();

		if ($this->card->load(Yii::$app->request->post()))	{

			if (Yii::$app->request->isAjax) 
				return $this->ajaxValidate($this->card);

			if ($this->card->save()) 
				return $this->redirect(['/card/card/view', 'id_card' => $this->card->id, 'id_mode' => $this->id_mode]); 
		}	

		return $this->render('form', ['returnUrl' => $this->getReferrer(['index'])]);
	}

}
