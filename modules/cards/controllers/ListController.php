<?php

namespace app\modules\cards\controllers;

use Yii;

use app\modules\cards\models\Card;

//*****************************************************************************
class ListController extends \dmitrybtn\cp\CrudController
//*****************************************************************************
{

	public const modes = [
		'my' => 'Мои техкарты',
		'common' => 'Общие техкарты',
		'subscr' => 'Мои подписки',
		'create' => 'Создать техкарту',
	];

	//-------------------------------------------------------------------------
	public function actionIndex($id_mode, $ss = '')
	//-------------------------------------------------------------------------
	{
		$this->model = new Card();
		$this->model->search_string = $ss;

		$this->title = static::modes[$id_mode];

		$this->menu = [
			['label' => 'Опции'],
			['label' => self::title('create'), 'url' => ['create', 'id_mode' => $this->id_mode], 'visible' => $this->id_mode == 'my'],
		];

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

		return $this->render('recent');
	}	
}
