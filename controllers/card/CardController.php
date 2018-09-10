<?php

namespace app\controllers\card;

use Yii;

use app\models\Card;

use yii\helpers\Url;


//*****************************************************************************
class CardController extends \dmitrybtn\cp\Controller
//*****************************************************************************
{
	public $card;


	public function to($url = '')
	{
		if (!is_array($url))
			throw new \yii\web\NotFoundHttpException('Некорректное использование построителя ссылок!');

		$url[0] = '/card/' . ltrim($url[0], '/');
		$url['id_card'] = $this->card->id;

		return $url;
	}

	public function init()
	{
		$id = Yii::$app->request->get('id_card');

		if (($this->card = Card::findOne($id)) === null)
			throw new \yii\web\NotFoundHttpException('Карта не найдена!');
	}
	

	public function actionPlan()
	{
		return $this->render('@app/views/card/card-plan.php');
	}


	public function actionText()
	{
		return $this->render('@app/views/card/card-text.php');
	}

}
