<?php

namespace app\modules\cards\controllers;

use Yii;

use app\modules\cards\models\Card;

use yii\helpers\Url;


//*****************************************************************************
class BaseController extends \dmitrybtn\cp\CrudController
//*****************************************************************************
{
	public $card;

	public $layout = '@app/modules/cards/views/layouts/layout';

	public $showPlan = false;
	public $showNavMobile = false;

	//-------------------------------------------------------------------------
	public function init()
	//-------------------------------------------------------------------------
	{
		// Загрузить карту
		$this->card = Card::find()->bySid(Yii::$app->request->get('id_card'))->one();

		if ($this->card !== null) $this->card->registerViewing();
		else throw new \yii\web\NotFoundHttpException('Карта не найдена!');

		// Отключить хлебные крошки
        if (Yii::$app->user->isGuest)
        	$this->showBreads = false;
	}

	//-------------------------------------------------------------------------
	public function to($url)
	//-------------------------------------------------------------------------
	{
		$url['id_card'] = $this->card->sid;

		return $url;
	}


	//-------------------------------------------------------------------------
	public function getTransfers()
	//-------------------------------------------------------------------------
	{
		if ($this->_transfers === null)
			$this->_transfers = $this->card->getTransfers()
				->with('objects', 'objects.objectImages', 'objects.objectImages.image')
				->sorted()
				->all();
		
		return $this->_transfers;

	} private $_transfers;

}
