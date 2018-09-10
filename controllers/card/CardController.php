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
	public $mode;

	public function to($url = '')
	{
		if (!is_array($url))
			throw new \yii\web\NotFoundHttpException('Некорректное использование построителя ссылок!');

		$url[0] = '/card/' . ltrim($url[0], '/');

		$url['id_card'] = $this->card->id;
		$url['mode'] = $this->mode;

		return $url;
	}

	public function init()
	{	
		$id = Yii::$app->request->get('id_card');

		if (($this->card = Card::findOne($id)) === null)
			throw new \yii\web\NotFoundHttpException('Карта не найдена!');

		$this->mode = Yii::$app->request->get('mode');
	}
	

    public function getTitle()
    {       
        return $this->card->name;
    } 


	//-------------------------------------------------------------------------
    public function getBreads()
	//-------------------------------------------------------------------------
    {
		return [
			['label' => $this->mode, 'url' => ['/site/index']],
		];    	
    }



	public function actionView()
	{
		return $this->render('@app/views/card/card-plan.php');
	}


	public function actionText()
	{
		return $this->render('@app/views/card/card-text.php');
	}

}
