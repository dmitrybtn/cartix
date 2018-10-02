<?php

namespace app\modules\cards\controllers\one;

use Yii;
use dmitrybtn\cp\SortAction;
use app\modules\cards\models\CardTransfer;

//*****************************************************************************
class TransferController extends \app\modules\cards\controllers\BaseController
//*****************************************************************************
{
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
	public static function title($actionId, $model = null)
	//-------------------------------------------------------------------------
	{
		return [
			'create' => 'Добавить остановку',
			'update' => 'Редактировать остановку',
			'delete' => 'Удалить остановку',
		][$actionId];
	}

	//-------------------------------------------------------------------------
	public function actionReplace($id_transfer, $index)
	//-------------------------------------------------------------------------
	// Смена сортировки
	{
		$modTransfer = $this->find($id_transfer);
		$modTransfer->sortIndex($index);
	}

	//-------------------------------------------------------------------------
	public function actionCreate()
	//-------------------------------------------------------------------------
	{
		$this->model = new CardTransfer();
		$this->model->id_card = $this->card->id;

		$returnUrl = Yii::$app->request->post('returnUrl', $this->getReferrer(['view', 'id' => $this->model->id]));

		if ($this->model->load(Yii::$app->request->post()))	{

			if (Yii::$app->request->isAjax) 
				return $this->ajaxValidate($this->model);

			if ($this->model->save()) 
				return $this->redirect($returnUrl); 
		}	

		return $this->render('form', ['returnUrl' => $this->getReferrer(['index'])]);
	}


	//-------------------------------------------------------------------------
	public function actionAjaxCreate()
	//-------------------------------------------------------------------------
	{
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		$this->model = new CardTransfer();
		$this->model->id_card = $this->card->id;

		if ($this->model->load(Yii::$app->request->post()))	{
			if ($this->model->save()) return ['status' => 'ok'];
			else return ['status' => 'error', 'html' => $this->renderPartial('form-modal-create', ['modTransfer' => $this->model])];
		}	
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

		return $this->render('form', [$this->model, 'returnUrl' => $returnUrl]);
	}


	//-------------------------------------------------------------------------
	public function actionAjaxUpdate($id)
	//-------------------------------------------------------------------------
	{
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		// $this->title = '';

		$this->model = $this->find($id);

		if ($this->model->load(Yii::$app->request->post()))	{
			if ($this->model->save()) return ['status' => 'ok'];
			else return ['status' => 'error', 'html' => $this->renderPartial('form-modal-update', ['modTransfer' => $this->model])];
		}	

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
	public function actionAjaxDelete($id)
	//-------------------------------------------------------------------------
	{
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		if (Yii::$app->request->isPost) {
			try {		

				$this->find($id)->delete();
				return ['status' => 'ok'];

			} catch (\Exception $e) {

				return ['status' => 'error', 'message' => $e->getMessage()];

			}		
		} else return ['status' => 'error', 'message' => 'Неверный формат запроса'];
	}


	//-------------------------------------------------------------------------
	public function find($id)
	//-------------------------------------------------------------------------
	{
		if (($modCardTransfer = CardTransfer::findOne($id)) !== null) {
			
			if ($modCardTransfer->id_card == $this->card->id) return $modCardTransfer;
			else throw new \yii\web\NotFoundHttpException('Техкарта не найдена');

		} else throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
	}
}
