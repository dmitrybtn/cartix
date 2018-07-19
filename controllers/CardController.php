<?php

namespace app\controllers;

use Yii;

use app\models\Card;
use app\models\CardImage;

use igogo5yo\uploadfromurl\UploadFromUrl;
use yii\web\UploadedFile;

//*****************************************************************************
class CardController extends \dmitrybtn\cp\Controller
//*****************************************************************************
{
	public $model;

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
			'index' => 'Мои техкарты',
			'create' => 'Добавить',
			'update' => 'Настройки техкарты',
			'delete' => 'Удалить техкарту',
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
				// $breads[] = ['action' => 'index'];
		}

		return $breads;
	}


	//-------------------------------------------------------------------------
	public function actionIndex($ss = '')
	//-------------------------------------------------------------------------
	{
		$modCard = new Card(['scenario' => 'search']);
		$modCard->search_string = $ss;

		$this->showBreads = false;

		$this->menu = [
			['label' => 'Опции'],
			['action' => 'create'],
		];
		
		return $this->render('index', ['modCard' => $modCard]);
	}

	//-------------------------------------------------------------------------
	public function actionView($id)
	//-------------------------------------------------------------------------
	{
		$this->model = $this->find($id);

		$this->menu = [
			['label' => 'Опции'],
			['label' => 'Добавить остановку', 'url' => ['/transfer/create', 'id' => $this->model->id]],
			['action' => 'update', 'params' => ['id' => $this->model->id]],
			['action' => 'delete', 'params' => ['id' => $this->model->id], 'linkOptions' => ['data' => ['confirm' => 'Точно?', 'method' => 'POST']]],
		];

		return $this->render('view-plan', ['modCard' => $this->model]);
	}

	//-------------------------------------------------------------------------
	public function actionViewImages($id)
	//-------------------------------------------------------------------------
	{
		$this->model = $this->find($id);
		$this->title = $this->title('view');

		$modNewImage = new CardImage;
		$modNewImage->id_card = $id;

		if (Yii::$app->request->post('url')) {
			$modNewImage->url = Yii::$app->request->post('url');

			if ($modNewImage->validate()) {
				$modNewImage->scenario = 'url';
				$modNewImage->file = UploadFromUrl::initWithUrl($modNewImage->url);

				if ($modNewImage->save())
					return Yii::$app->getResponse()->redirect($this->getReferrer(), 302, false);
			}
		} elseif ($arrFiles = UploadedFile::getInstancesByName('file')) {
			
			$notSaved = 0;

			foreach ($arrFiles as $objFile) {
				$modImage = new CardImage;
				$modImage->id_card = $id;
				$modImage->file = $objFile; 

				if (!$modImage->save()) $notSaved++;
			}

			if ($notSaved)
				Yii::$app->session->addFlash('error', "Не удалось загрузить $notSaved изображений");

			return Yii::$app->getResponse()->redirect($this->getReferrer(), 302, false);
		}

		$this->menu = [
			['label' => 'Опции'],
			['label' => 'Добавить остановку', 'url' => ['/transfer/create', 'id' => $this->model->id]],
			['action' => 'update', 'params' => ['id' => $this->model->id]],
			['action' => 'delete', 'params' => ['id' => $this->model->id], 'linkOptions' => ['data' => ['confirm' => 'Точно?', 'method' => 'POST']]],
		];

		return $this->render('view-images', ['modCard' => $this->model, 'modNewImage' => $modNewImage]);
	}

	//-------------------------------------------------------------------------
	public function actionViewText($id)
	//-------------------------------------------------------------------------
	{
		$this->model = $this->find($id);

		$this->title = $this->title('view');

		$this->menu = [
			['label' => 'Опции'],
			['label' => 'Добавить остановку', 'url' => ['/transfer/create', 'id' => $this->model->id]],
			['action' => 'update', 'params' => ['id' => $this->model->id]],
			['action' => 'delete', 'params' => ['id' => $this->model->id], 'linkOptions' => ['data' => ['confirm' => 'Точно?', 'method' => 'POST']]],
		];

		return $this->render('view-text', ['modCard' => $this->model]);
	}


	//-------------------------------------------------------------------------
	public function actionCreate()
	//-------------------------------------------------------------------------
	{
		$this->model = new Card();

		if ($this->model->load(Yii::$app->request->post()))	{

			if (Yii::$app->request->isAjax) 
				return $this->ajaxValidate($this->model);

			if ($this->model->save()) 
				return $this->redirect(['view', 'id' => $this->model->id]); 
		}	

		return $this->render('form', ['modCard' => $this->model, 'returnUrl' => $this->getReferrer(['index'])]);
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

		return $this->render('form', ['modCard' => $this->model, 'returnUrl' => $returnUrl]);
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
		if (($modCard = Card::findOne($id)) !== null) return $modCard;
		else throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
	}
}
