<?php

namespace app\controllers;

use Yii;

use app\models\Card;

//*****************************************************************************
class CardController extends \dmitrybtn\cp\CrudController
//*****************************************************************************
{

	public $mode;

	//-------------------------------------------------------------------------
	public function actionIndex($ss = '')
	//-------------------------------------------------------------------------
	{
		$this->mode = 'my';

		$this->model = new Card(['scenario' => 'search']);
		$this->model->search_string = $ss;

		$this->showBreads = false;

		$this->menu = [
			['label' => 'Опции'],
			['label' => self::title('create'), 'url' => ['create']],
		];
		
		return $this->render('index');
	}


	//-------------------------------------------------------------------------
	public function actionCommon($ss = '')
	//-------------------------------------------------------------------------
	{
		$this->mode = 'common';

		$this->model = new Card(['scenario' => 'search']);
		$this->model->search_string = $ss;

		$this->showBreads = false;

		$this->menu = [
			['label' => 'Опции'],
			['label' => self::title('create'), 'url' => ['create']],
		];
		
		return $this->render('index');
	}

}
