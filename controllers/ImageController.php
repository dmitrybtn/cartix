<?php

namespace app\controllers;

use Yii;
use dmitrybtn\cp\SortAction;
use app\models\CardImage;

//*****************************************************************************
class ImageController extends \dmitrybtn\cp\Controller
//*****************************************************************************
{
	public $model;
	
	//-------------------------------------------------------------------------
	public function actions()
	//-------------------------------------------------------------------------
	{
		return [
			'sort' => [
				'class' => SortAction::class,
			]
		];
	}

	//-------------------------------------------------------------------------
	public function behaviors()
	//-------------------------------------------------------------------------
	{
		return [
			'verbs' => [
				'class' => \yii\filters\VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	//-------------------------------------------------------------------------
	public function actionDelete($id)
	//-------------------------------------------------------------------------
	{
		try {		

			$this->find($id)->delete();

		} catch (\Exception $e) {

			Yii::$app->session->setFlash('error', $e->getMessage());
			return $this->goReferrer();

		}

		return Yii::$app->getResponse()->redirect($this->getReferrer(), 302, false);
	}

	//-------------------------------------------------------------------------
	public function find($id)
	//-------------------------------------------------------------------------
	{
		if (($modCardImage = CardImage::findOne($id)) !== null) return $modCardImage;
		else throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
	}
}
