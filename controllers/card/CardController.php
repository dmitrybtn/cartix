<?php

namespace app\controllers\card;

use Yii;

use app\models\Card;

use yii\helpers\Url;


//*****************************************************************************
class CardController extends BaseController
//*****************************************************************************
{
	//-------------------------------------------------------------------------
	public function to($url = '')
	//-------------------------------------------------------------------------
	{
		if (!is_array($url))
			throw new \yii\web\NotFoundHttpException('Некорректное использование построителя ссылок!');

		$url[0] = '/card/' . ltrim($url[0], '/');

		$url['id_card'] = $this->card->id;
		$url['id_mode'] = $this->id_mode;

		return $url;
	}

	//-------------------------------------------------------------------------
    public function getTitle()
	//-------------------------------------------------------------------------
    {       
        return $this->card->name;
    } 

	//-------------------------------------------------------------------------
	public function actionView()
	//-------------------------------------------------------------------------
	{
		return $this->render('@app/views/card/card-plan.php');
	}

	//-------------------------------------------------------------------------
	public function actionText()
	//-------------------------------------------------------------------------
	{
		return $this->render('@app/views/card/card-text.php');
	}

}
