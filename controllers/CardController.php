<?php

namespace app\controllers;

use Yii;

use app\models\Card;
use app\models\CardImage;

use igogo5yo\uploadfromurl\UploadFromUrl;
use yii\web\UploadedFile;

//*****************************************************************************
class CardController extends \dmitrybtn\cp\CrudController
//*****************************************************************************
{
	//-------------------------------------------------------------------------
	public static function title($actionId, $model = null)
	//-------------------------------------------------------------------------
	{
		return [
			'index' => 'Мои техкарты',
			'create' => 'Добавить',
			'update' => 'Настройки техкарты',
			'delete' => 'Удалить техкарту',
			'view' => $model->name ?? 'Просмотр',
		][$actionId];
	}

	//-------------------------------------------------------------------------
	public static function breads($actionId, $model = null)
	//-------------------------------------------------------------------------
	{
		$breads = [];

		switch ($actionId) {			
			case 'index':
				break;

			case 'outer';
			case 'update':
				$breads[] = ['label' => self::title('view', $model), 'url' => ['/card/view', 'id' => $model->id]];
				
			default:
		}

		return $breads;
	}


	//-------------------------------------------------------------------------
	public function actionIndex($ss = '')
	//-------------------------------------------------------------------------
	{
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
	public function actionView($id)
	//-------------------------------------------------------------------------
	{
		$this->model = $this->find($id);

		$this->menu = [
			['label' => 'Опции'],
			['label' => TransferController::title('create'), 'url' => ['/transfer/create', 'id' => $this->model->id]],
			['label' => self::title('update'), 'url' => ['update', 'id' => $this->model->id]],
			['label' => self::title('delete'), 'url' => ['delete', 'id' => $this->model->id], 'linkOptions' => ['data' => ['confirm' => 'Точно?', 'method' => 'POST']]],
		];

		return $this->render('view-plan', ['modCard' => $this->model]);
	}

	//-------------------------------------------------------------------------
	public function actionViewImages($id)
	//-------------------------------------------------------------------------
	{
		$this->model = $this->find($id);
		$this->title = self::title('view');

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
			['label' => self::title('update'), 'url' => ['update', 'id' => $this->model->id]],
			['label' => self::title('delete'), 'url' => ['delete', 'id' => $this->model->id], 'linkOptions' => ['data' => ['confirm' => 'Точно?', 'method' => 'POST']]],
		];

		return $this->render('view-images', ['modCard' => $this->model, 'modNewImage' => $modNewImage]);
	}

	//-------------------------------------------------------------------------
	public function actionViewText($id)
	//-------------------------------------------------------------------------
	{
		$this->model = $this->find($id);

		$this->title = self::title('view');

		$this->menu = [
			['label' => 'Опции'],
			['label' => self::title('update'), 'url' => ['update', 'id' => $this->model->id]],
			['label' => self::title('delete'), 'url' => ['delete', 'id' => $this->model->id], 'linkOptions' => ['data' => ['confirm' => 'Точно?', 'method' => 'POST']]],
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

		return $this->render('form', ['returnUrl' => $this->getReferrer(['index'])]);
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
		if (Yii::$app->request->isPost || YII_ENV_TEST) {
			try {		

				$this->find($id)->delete();
				return Yii::$app->getResponse()->redirect($this->getReferrer(), 302, false);

			} catch (\Exception $e) {

				Yii::$app->session->setFlash('error', $e->getMessage());
				return Yii::$app->getResponse()->redirect($this->getReferrer());

			}		
		} throw new \yii\web\MethodNotAllowedHttpException('Неверный формат запроса!');
	}

	//-------------------------------------------------------------------------
	public function find($id)
	//-------------------------------------------------------------------------
	{
		if (($modCard = Card::findOne($id)) !== null) return $modCard;
		else throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
	}
}
