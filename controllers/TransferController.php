<?php

namespace app\controllers;

use Yii;
use dmitrybtn\cp\SortAction;
use app\models\CardTransfer;

//*****************************************************************************
class TransferController extends \dmitrybtn\cp\Controller
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
					'delete' => [YII_ENV_TEST ? 'GET' : 'POST'],
				],
			],
		];
	}

	//-------------------------------------------------------------------------
	public function titles()
	//-------------------------------------------------------------------------
	{
		return [
			'create' => 'Добавить остановку',
			'update' => 'Редактировать остановку',
			'delete' => 'Удалить',
			'view' => $this->model ? $this->model->getTitle() : 'Просмотр',
		];
	}

	//-------------------------------------------------------------------------
	public function breads($actionId)
	//-------------------------------------------------------------------------
	{
		return [
			['label' => $this->model->card->getTitle(), 'url' => ['/card/view', 'id' => $this->model->card->id]],
			// ['label' => 'Техкарты', 'url' => ['/card/index']],
		];
	}


	//-------------------------------------------------------------------------
	public function actionCreate($id)
	//-------------------------------------------------------------------------
	{
		$this->model = new CardTransfer();
		$this->model->id_card = $id;

		if ($this->model->load(Yii::$app->request->post()))	{

			if (Yii::$app->request->isAjax) 
				return $this->ajaxValidate($this->model);

			if ($this->model->save()) 
				return $this->redirect(['/card/view', 'id' => $this->model->id_card]); 
		}	

		return $this->render('form', ['modCardTransfer' => $this->model, 'returnUrl' => $this->getReferrer(['index'])]);
	}

	//-------------------------------------------------------------------------
	public function actionUpdate($id)
	//-------------------------------------------------------------------------
	{
		$this->model = $this->find($id);

		$returnUrl = Yii::$app->request->post('returnUrl', $this->getReferrer(['view', 'id' => $this->model->id]));

		if ($this->model->load(Yii::$app->request->post()))	{
			
			if (Yii::$app->request->isAjax) 
				return $this->ajaxValidate($this->model);
			
			if ($this->model->save()) 
				return $this->redirect($returnUrl);
		}	

		return $this->render('form', ['modCardTransfer' => $this->model, 'returnUrl' => $returnUrl]);
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
		if (($modCardTransfer = CardTransfer::findOne($id)) !== null) return $modCardTransfer;
		else throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
	}
}
