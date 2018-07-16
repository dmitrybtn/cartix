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
		return $this->render('index');
	}
}
