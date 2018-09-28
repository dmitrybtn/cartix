<?php

namespace app\modules\cards\controllers\one;

use Yii;
use dmitrybtn\cp\SortAction;
use app\modules\cards\models\CardObject;

//*****************************************************************************
class ObjectController extends \app\modules\cards\controllers\BaseController
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
			'create' => 'Добавить объект',
			'update' => 'Редактировать объект',
			'delete' => 'Удалить',
		][$actionId];
	}

	/*
	//-------------------------------------------------------------------------
	public static function breads($actionId, $model = null)
	//-------------------------------------------------------------------------
	{
		return CardController::breads('outer', $model->card);
	}
	*/

	//-------------------------------------------------------------------------
	public function actionReplace($id_object, $id_transfer, $index)
	//-------------------------------------------------------------------------
	// Смена сортировки
	{
		$modObject = $this->find($id_object);
		
		$changeTransfer = $modObject->id_transfer != $id_transfer;

		$modObject->id_transfer = $id_transfer;
		$modObject->sortIndex($index, $changeTransfer);
	}

	//-------------------------------------------------------------------------
	public function actionCreate($id)
	//-------------------------------------------------------------------------
	{
		$this->model = new CardObject();
		$this->model->id_transfer = $id;

		if ($this->model->load(Yii::$app->request->post()))	{

			if (Yii::$app->request->isAjax) 
				return $this->ajaxValidate($this->model);

			if ($this->model->save()) 
				return $this->redirect($this->to(['/cards/one/view/plan'])); 
		}	

		return $this->render('form', ['returnUrl' => $this->getReferrer(['index'])]);
	}

	//-------------------------------------------------------------------------
	public function actionUpdate($id)
	//-------------------------------------------------------------------------
	{
		$this->model = $this->find($id);

		$returnUrl = Yii::$app->request->post('returnUrl', $this->getReferrer($this->to(['/cards/one/view/plan', 'id' => $this->model->id])));

		// $returnUrl = $this->to(['/cards/one/view/text', '#' => 'object-' . $this->model->id]);

		if ($this->model->load(Yii::$app->request->post()))	{
			
			if (Yii::$app->request->isAjax) 
				return $this->ajaxValidate($this->model);
			
			if ($this->model->save()) 
				return $this->redirect($returnUrl);
		}	

		return $this->render('form', ['returnUrl' => $returnUrl]);
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
		if (($modCardObject = CardObject::findOne($id)) !== null) {
			if ($modCardObject->transfer->id_card == $this->card->id) return $modCardObject;
			else throw new \yii\web\NotFoundHttpException('Техкарта не найдена');
		} else throw new \yii\web\NotFoundHttpException('The requested page does not exist.');		
	}
}
