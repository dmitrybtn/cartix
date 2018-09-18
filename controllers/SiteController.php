<?php

namespace app\controllers;

use Yii;

class SiteController extends \dmitrybtn\cp\Controller
{
	//-------------------------------------------------------------------------
	public function actions()
	//-------------------------------------------------------------------------
	{
		return [
			'error' => [
				'class' => 'dmitrybtn\cp\ErrorAction',
			],
		];
	}

	//-------------------------------------------------------------------------
	public function actionIndex()
	//-------------------------------------------------------------------------
	{
		$this->showBreads = false;

		return $this->render('index');
	}
}
