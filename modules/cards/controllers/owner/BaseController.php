<?php

namespace app\modules\cards\controllers\owner;

use Yii;

//*****************************************************************************
class BaseController extends \app\modules\cards\controllers\BaseController
//*****************************************************************************
{
	//-------------------------------------------------------------------------
	public function init()
	//-------------------------------------------------------------------------
	{
		parent::init();

		Yii::$app->errorHandler->errorAction = '/cards/view/error';

		if (!$this->card->isMy)
			throw new \yii\web\ForbiddenHttpException('Действие доступно только владельцу карты');
	}




}
