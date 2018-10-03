<?php

namespace app\modules\cards\controllers;

use Yii;

use app\modules\cards\controllers\owner\{TransferController};

use app\modules\cards\models\{Card, CardImage};

//*****************************************************************************
class ViewController extends \app\modules\cards\controllers\BaseController
//*****************************************************************************
{
	// public $layout = '@app/modules/cards/views/layouts/layout-view';

	// public $showHeader = false;

	public $showNavMobile = true;

	//-------------------------------------------------------------------------
	public function init()
	//-------------------------------------------------------------------------
	{
		parent::init();
		
		$this->card->viewer->tst_view = time();
		$this->card->viewer->save();

		$this->title = $this->card->title;
		$this->breads = [];
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
		$this->menu = [
			['label' => 'Опции'],
			['label' => TransferController::title('create'), 'url' => '#', 'options' => ['class' => 'hidden-xs hidden-sm'], 'linkOptions' => ['data-toggle' => 'modal', 'data-target' => '.cards_plan_transfer--modal-create']],
			['label' => TransferController::title('create'), 'url' => $this->to(['/cards/owner/transfer/create']), 'options' => ['class' => 'visible-xs-block visible-sm-block']],
		];

		if (Yii::$app->request->isAjax) return $this->renderAjax('plan');
		else return $this->render('plan');
	}

	//-------------------------------------------------------------------------
	public function actionText()
	//-------------------------------------------------------------------------
	{
		$this->showPlan = true;

		return $this->render('text');
	}

	//-------------------------------------------------------------------------
	public function actionImages()
	//-------------------------------------------------------------------------
	{
		$this->showPlan = true;

		return $this->render('images');
	}

}