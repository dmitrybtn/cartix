<?php

namespace app\controllers;

use Yii;
use dmitrybtn\cp\SortAction;
use app\models\CardImage;

use igogo5yo\uploadfromurl\UploadFromUrl;
use yii\web\UploadedFile;
use yii\helpers\Html;


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
	public function actionCreate($id)
	//-------------------------------------------------------------------------
	{
		$this->model = new CardImage();
		$this->model->id_card = $id;

		if ($this->model->load(Yii::$app->request->post()))	{

			if (Yii::$app->request->isAjax) 
				return $this->ajaxValidate($this->model);

			if ($this->model->validate()) {
				if ($this->model->url) {
					$this->model->scenario = 'url';
					$this->model->file = UploadFromUrl::initWithUrl($this->model->url);
				} else {
					$this->model->scenario = 'file';
					$this->model->file = UploadedFile::getInstance($this->model, 'file');
				}
			}

			if (!$this->model->save()) 
				Yii::$app->session->addFlash('error', Html::errorSummary($this->model, ['header' => '<p>Не удалось загрузить картинку:</p>']));
		}	

		return $this->goReferrer(); 
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
