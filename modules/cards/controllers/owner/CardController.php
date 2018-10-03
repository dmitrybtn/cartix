<?php

namespace app\modules\cards\controllers\owner;

use Yii;

use app\modules\cards\models\Card;

//*****************************************************************************
class CardController extends BaseController
//*****************************************************************************
{

	//-------------------------------------------------------------------------
	public static function title($actionId, $model = null)
	//-------------------------------------------------------------------------
	{
		return [
			'update' => 'Настройки',
		][$actionId];
	}


	//-------------------------------------------------------------------------
	public function actionUpdate()
	//-------------------------------------------------------------------------
	{
		$returnUrl = Yii::$app->request->post('returnUrl', $this->getReferrer(['view', 'id' => $this->card->id]));

		if ($this->card->load(Yii::$app->request->post()))	{
			
			if (Yii::$app->request->isAjax) 
				return $this->ajaxValidate($this->card);
			
			if ($this->card->save()) 
				return $this->redirect($returnUrl);
		}	

		return $this->render('@app/modules/cards/views/form.php', ['returnUrl' => $returnUrl]);
	}

	//-------------------------------------------------------------------------
	public function actionDelete()
	//-------------------------------------------------------------------------
	{
		if (Yii::$app->request->isPost || YII_ENV_TEST) {

			$url = ['/cards/card/index', 'id_mode' => 'my'];

			try {		

				$this->card->delete();
				return Yii::$app->getResponse()->redirect($url, 302, false);

			} catch (\Exception $e) {

				Yii::$app->session->setFlash('error', $e->getMessage());
				return Yii::$app->getResponse()->redirect($url);

			}		
		} throw new \yii\web\MethodNotAllowedHttpException('Неверный формат запроса!');
	}

}
