<?php

namespace app\modules\cards\controllers\one;

use Yii;

use app\modules\cards\models\Card;

use yii\helpers\Url;


//*****************************************************************************
class CardController extends \app\modules\cards\controllers\BaseController
//*****************************************************************************
{

	//-------------------------------------------------------------------------
	public function init()
	//-------------------------------------------------------------------------
	{
		parent::init();

		$this->model = $this->card;
	}

	//-------------------------------------------------------------------------
	public static function needMy($action = null)
	//-------------------------------------------------------------------------
	// Действия, доступные только владельцу карты
	{
		return in_array($action, [
			'update',
			'delete',
		]);
	}


	//-------------------------------------------------------------------------
	public static function title($actionId, $modCard = null)
	//-------------------------------------------------------------------------
	{
		return [
			'update' => 'Настройки техкарты',
			'delete' => 'Удалить техкарту',
		][$actionId] ?? $modCard->name;
	}

	//-------------------------------------------------------------------------
	public static function breads($actionId, $modCard = '')
	//-------------------------------------------------------------------------
	{
		$breads = [];

		switch ($actionId) {			
			case 'index':
				break;

			case 'update':
			case 'outer':
				$breads[] = ['label' => static::title('view', $modCard), 'url' => ['/cards/one/view/plan']];				
		}

		return $breads;
	}

	//-------------------------------------------------------------------------
	public function actionSubscribe()
	//-------------------------------------------------------------------------
	{
		$this->card->subscribeToggle();

		return $this->goReferrer();
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

			$url = ['/cards/list//index', 'id_mode' => $this->id_mode];

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
