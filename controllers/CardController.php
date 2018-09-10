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


	//-------------------------------------------------------------------------
	public static function title($actionId)
	//-------------------------------------------------------------------------
	{
		return [
			'create' => 'Добавить',
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
			['label' => self::title('create'), 'url' => ['create', 'id_mode' => $this->id_mode]],
		];
		
		return $this->render('@app/views/card/list.php', ['modCard' => $modCard]);
	}

	//-------------------------------------------------------------------------
	public function actionCreate()
	//-------------------------------------------------------------------------
	{
		$this->model = new Card();

		if ($this->model->load(Yii::$app->request->post()))	{

			if (Yii::$app->request->isAjax) 
				return $this->ajaxValidate($this->model);

			if ($this->model->save()) 
				return $this->redirect(['view', 'id' => $this->model->id]); 
		}	

		return $this->render('form', ['returnUrl' => $this->getReferrer(['index'])]);
	}

}
