<?php

namespace app\controllers\card;

use Yii;

use app\models\Card;

use yii\helpers\Url;


//*****************************************************************************
class BaseController extends \dmitrybtn\cp\CrudController
//*****************************************************************************
{
	public $id_mode;
	public $card;

	//-------------------------------------------------------------------------
	public function init()
	//-------------------------------------------------------------------------
	{
		$this->id_mode = Yii::$app->request->get('id_mode');

		if (($this->card = Card::find()->bySid(Yii::$app->request->get('id_card'))->one()) === null)
			throw new \yii\web\NotFoundHttpException('Карта не найдена!');

        if (Yii::$app->user->isGuest)
        	$this->showBreads = false;
	}


	//-------------------------------------------------------------------------
	public function to($url = '')
	//-------------------------------------------------------------------------
	{
		if (!is_array($url))
			throw new \yii\web\NotFoundHttpException('Некорректное использование построителя ссылок!');

		// $url[0] = '/card/one/' . ltrim($url[0], '/');

		$url['id_card'] = $this->card->sid;
		$url['id_mode'] = $this->id_mode;

		return $url;
	}


	//-------------------------------------------------------------------------
	public static function mode($id_mode)
	//-------------------------------------------------------------------------
	{
		return [
			'my' => 'Мои техкарты',
			'common' => 'Общие',
			'subscr' => 'Мои подписки',
		][$id_mode];
	}


	//-------------------------------------------------------------------------
	public function checkCard($throw = false)
	//-------------------------------------------------------------------------
	{
		if (!$this->card->isMy) {
			if ($throw) throw new \yii\web\ForbiddenHttpException('Можно редактировать только свои техкарты');
			else return false;
		} else return true;
	}


	//-------------------------------------------------------------------------
    public function getBreads()
	//-------------------------------------------------------------------------
    {

        $arrBreads = parent::getBreads();

        // Применить преобразование URL
        foreach ($arrBreads as $k => $sttBread) 
        	$arrBreads[$k]['url'] = $this->to($sttBread['url']);

        // Добавить ссылку на режим
        if ($this->id_mode)
        	array_unshift($arrBreads, ['label' => static::mode($this->id_mode), 'url' => ['/card/list/index', 'id_mode' => $this->id_mode]]);

        return $arrBreads;
    }


}