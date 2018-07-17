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
	public function titles()
	//-------------------------------------------------------------------------
	{
		return [
			'index' => 'Администрирование',
			'create' => 'Добавить',
			'update' => 'Редактировать',
			'delete' => 'Удалить',
			'view' => $this->model ? $this->model->getTitle() : 'Просмотр',
		];
	}

	//-------------------------------------------------------------------------
	public function breads($actionId)
	//-------------------------------------------------------------------------
	{
		$breads = [];

		switch ($actionId) {			
			case 'index':
				break;

			case 'update':
				$breads[] = ['action' => 'view', 'params' => ['id' => $this->model->id]];
				
			default:
				$breads[] = ['action' => 'index'];
		}

		return $breads;
	}


	//-------------------------------------------------------------------------
	public function actionIndex($ss = '')
	//-------------------------------------------------------------------------
	{
		$modCardImage = new CardImage(['scenario' => 'search']);
		$modCardImage->search_string = $ss;

		$this->menu = [
			['label' => 'Опции'],
			['action' => 'create'],
		];
		
		return $this->render('index', ['modCardImage' => $modCardImage]);
	}

	//-------------------------------------------------------------------------
	public function actionView($id)
	//-------------------------------------------------------------------------
	{
		$this->model = $this->find($id);

		$this->menu = [
			['label' => 'Опции'],
			['action' => 'update', 'params' => ['id' => $this->model->id]],
			['action' => 'delete', 'params' => ['id' => $this->model->id], 'linkOptions' => ['data' => ['confirm' => 'Точно?', 'method' => 'POST']]],
		];

		return $this->render('view', ['modCardImage' => $this->model]);
	}

	//-------------------------------------------------------------------------
	public function actionCreate()
	//-------------------------------------------------------------------------
	{
		$this->model = new CardImage();

		if ($this->model->load(Yii::$app->request->post()))	{

			if (Yii::$app->request->isAjax) 
				return $this->ajaxValidate($this->model);

			if ($this->model->save()) 
				return $this->redirect(['view', 'id' => $this->model->id]); 
		}	

		return $this->render('form', ['modCardImage' => $this->model, 'returnUrl' => $this->getReferrer(['index'])]);
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

		return $this->render('form', ['modCardImage' => $this->model, 'returnUrl' => $returnUrl]);
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

		return $this->redirect(['index']);
	}

	//-------------------------------------------------------------------------
	public function find($id)
	//-------------------------------------------------------------------------
	{
		if (($modCardImage = CardImage::findOne($id)) !== null) return $modCardImage;
		else throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
	}
}
