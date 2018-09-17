<?php

namespace app\controllers\cards;

use Yii;

use app\models\Card;

use yii\helpers\Url;


//*****************************************************************************
class CardController extends BaseController
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
				$breads[] = ['label' => static::title('view', $modCard), 'url' => ['/cards/card/view']];				
		}

		return $breads;
	}


	//-------------------------------------------------------------------------
	public function actionView()
	//-------------------------------------------------------------------------
	{
		$this->menu = [
			['label' => 'Опции'],
			['label' => TransferController::title('create'), 'url' => $this->to(['/cards/transfer/create']), 'visible' => $this->checkCard()],
			['label' => self::title('update'), 'url' => $this->to(['update']), 'visible' => $this->checkCard()],
			['label' => self::title('delete'), 'url' => $this->to(['delete']), 'linkOptions' => ['data' => ['confirm' => 'Точно?', 'method' => 'POST']], 'visible' => $this->checkCard()],
		];

		return $this->render('view-plan');
	}

	//-------------------------------------------------------------------------
	public function actionText()
	//-------------------------------------------------------------------------
	{
		return $this->render('view-text');
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

		return $this->render('form', ['returnUrl' => $returnUrl]);
	}

	//-------------------------------------------------------------------------
	public function actionDelete()
	//-------------------------------------------------------------------------
	{
		if (Yii::$app->request->isPost || YII_ENV_TEST) {

			$url = ['/cards/index', 'id_mode' => $this->id_mode];

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
