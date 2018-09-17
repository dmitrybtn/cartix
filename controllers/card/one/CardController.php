<?php

namespace app\controllers\card\one;

use Yii;

use app\models\Card;

use yii\helpers\Url;


//*****************************************************************************
class CardController extends \app\controllers\card\BaseController
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
	public static function title($actionId, $modCard = null)
	//-------------------------------------------------------------------------
	{
		return [
			'update' => 'Настройки техкарты',
			'delete' => 'Удалить техкарту'
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
				$breads[] = ['label' => static::title('view', $modCard), 'url' => ['/card/one/card/view']];				
		}

		return $breads;
	}

	//-------------------------------------------------------------------------
	public function actionPlan()
	//-------------------------------------------------------------------------
	{
		$this->menu = [
			['label' => 'Опции'],
			['label' => TransferController::title('create'), 'url' => $this->to(['/card/one/transfer/create']), 'visible' => $this->checkCard()],
			['label' => self::title('update'), 'url' => $this->to(['update']), 'visible' => $this->checkCard()],
			['label' => self::title('delete'), 'url' => $this->to(['delete']), 'linkOptions' => ['data' => ['confirm' => 'Точно?', 'method' => 'POST']], 'visible' => $this->checkCard()],


			['label' => $this->card->is_common ? 'Убрать из базы' : 'Добавить в базу', 'url' => $this->to(['common'])],

			['label' => $this->card->subscribe ? 'Отписаться' : 'Подписаться', 'url' => $this->to(['subscribe']), 'visible' => !Yii::$app->user->isGuest && !$this->checkCard()],

		];

		return $this->render('@app/views/card/one/view-plan.php');
	}


	//-------------------------------------------------------------------------
	public function actionText()
	//-------------------------------------------------------------------------
	{
		return $this->render('@app/views/card/one/view-text.php');
	}


	//-------------------------------------------------------------------------
	public function actionSubscribe()
	//-------------------------------------------------------------------------
	{
		$this->card->subscribeToggle();

		return $this->goReferrer();
	}

	//-------------------------------------------------------------------------
	public function actionCommon()
	//-------------------------------------------------------------------------
	{
		$this->card->is_common = (int)(!(bool)$this->card->is_common);
		$this->card->save();

		return $this->goReferrer();
	}

	//-------------------------------------------------------------------------
	public function actionUpdate()
	//-------------------------------------------------------------------------
	{
		$this->checkCard(true);

		$returnUrl = Yii::$app->request->post('returnUrl', $this->getReferrer(['view', 'id' => $this->card->id]));

		if ($this->card->load(Yii::$app->request->post()))	{
			
			if (Yii::$app->request->isAjax) 
				return $this->ajaxValidate($this->card);
			
			if ($this->card->save()) 
				return $this->redirect($returnUrl);
		}	

		return $this->render('@app/views/card/form.php', ['returnUrl' => $returnUrl]);
	}

	//-------------------------------------------------------------------------
	public function actionDelete()
	//-------------------------------------------------------------------------
	{
		if (Yii::$app->request->isPost || YII_ENV_TEST) {

			$url = ['/card/list/index', 'id_mode' => $this->id_mode];

			try {		

				$this->checkCard(true);
				$this->card->delete();
				return Yii::$app->getResponse()->redirect($url, 302, false);

			} catch (\Exception $e) {

				Yii::$app->session->setFlash('error', $e->getMessage());
				return Yii::$app->getResponse()->redirect($url);

			}		
		} throw new \yii\web\MethodNotAllowedHttpException('Неверный формат запроса!');
	}

}
