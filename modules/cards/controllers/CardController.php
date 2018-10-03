<?php

namespace app\modules\cards\controllers;

use Yii;

use app\modules\cards\models\Card;

//*****************************************************************************
class CardController extends \dmitrybtn\cp\CrudController
//*****************************************************************************
{
	public $card;

	public const modes = [
		'my' => 'Мои техкарты',
		'common' => 'Общие техкарты',
		'subscr' => 'Мои подписки',
	];

	//-------------------------------------------------------------------------
	public static function title($actionId)
	//-------------------------------------------------------------------------
	{
		return [
			'create' => 'Создать техкарту',
			'recent' => Yii::$app->name,
		][$actionId];
	}


	//-------------------------------------------------------------------------
	public function actionIndex($id_mode, $ss = '')
	//-------------------------------------------------------------------------
	{
		$this->model = new Card();
		$this->model->search_string = $ss;

		$this->title = static::modes[$id_mode];

		if ($id_mode == 'my') {
			$this->menu = [
				['label' => 'Опции'],
				['label' => self::title('create'), 'url' => ['create']],
			];			
		}


		return $this->render('index', ['id_mode' => $id_mode]);
	}

	//-------------------------------------------------------------------------
	public function actionRecent()
	//-------------------------------------------------------------------------
	{
		$this->model = new Card;
		
		$this->title = Yii::$app->name;

		$this->showHeader = false;
		$this->showBreads = false;

		$this->menu = [
			['label' => 'Опции'],
			['label' => self::title('create'), 'url' => ['create']],
		];

		return $this->render('recent');
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
				return $this->redirect(['/cards/view/plan', 'id_card' => $this->card->sid]); 
		}	

		return $this->render('@app/modules/cards/views/form', ['returnUrl' => $this->getReferrer(['index'])]);
	}

	//-------------------------------------------------------------------------
	public function actionSubscribe($id_card)
	//-------------------------------------------------------------------------
	{
		$modCard = Card::find()->bySid($id_card)->one();
		$modCard->viewer->is_subscr = ($modCard->viewer->is_subscr + 1) % 2;
		$modCard->viewer->save();

		return $this->goReferrer();
	}

	//-------------------------------------------------------------------------
	public function actionCommon($id_card)
	//-------------------------------------------------------------------------
	{
		$modCard = Card::find()->bySid($id_card)->one();

		$modCard->is_common = ($modCard->is_common + 1) % 2;
		$modCard->save();

		return $this->goReferrer();
	}

}
