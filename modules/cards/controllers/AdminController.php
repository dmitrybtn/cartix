<?php

namespace app\modules\cards\controllers;

use Yii;

use app\models\Card;

use yii\helpers\Url;


//*****************************************************************************
class AdminController extends \app\controllers\card\BaseController
//*****************************************************************************
{
	//-------------------------------------------------------------------------
	public function init()
	//-------------------------------------------------------------------------
	{
		parent::init();

		$this->model = $this->card;
	}

	//-------------------------------------------------------------------------
	public function actionCommon()
	//-------------------------------------------------------------------------
	{
		$this->card->is_common = (int)(!(bool)$this->card->is_common);
		$this->card->save();

		return $this->goReferrer();
	}
}
