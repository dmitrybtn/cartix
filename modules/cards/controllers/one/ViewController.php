<?php

namespace app\modules\cards\controllers\one;

use Yii;

use app\modules\cards\models\{Card, CardImage};

//*****************************************************************************
class ViewController extends \app\modules\cards\controllers\BaseController
//*****************************************************************************
{
	public $layout = '@app/modules/cards/views/layouts/layout-view';

	public $showHeader = false;

	//-------------------------------------------------------------------------
	public function init()
	//-------------------------------------------------------------------------
	{
		parent::init();
		
		$this->title = $this->card->title;
	}

	//-------------------------------------------------------------------------
	public function actionRefreshPlan()
	//-------------------------------------------------------------------------
	{
		return $this->renderPartial('@app/modules/cards/views/layouts/layout-plan');
	}

	//-------------------------------------------------------------------------
	public function actionPlan()
	//-------------------------------------------------------------------------
	{
		if (Yii::$app->request->isAjax) return $this->renderAjax('plan');
		else return $this->render('plan');
	}

	//-------------------------------------------------------------------------
	public function actionText()
	//-------------------------------------------------------------------------
	{
		return $this->render('text');
	}

	//-------------------------------------------------------------------------
	public function actionImages()
	//-------------------------------------------------------------------------
	{
		return $this->render('images');
	}

}
