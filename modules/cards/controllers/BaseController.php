<?php

namespace app\modules\cards\controllers;

use Yii;

use app\modules\cards\models\Card;

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
	public static function needMy()
	//-------------------------------------------------------------------------
	// Возвращает true если для выполнения действия нужно быть владельцем карты
	{
		return true;
	}

	//-------------------------------------------------------------------------
	public static function checkMy($action)
	//-------------------------------------------------------------------------
	// Проверяет необходимость быть владельцем карточки
	{
		return static::needMy($action) ? Yii::$app->controller->card->isMy : true;
	}


	//-------------------------------------------------------------------------
	public function beforeAction($action)
	//-------------------------------------------------------------------------
	{
		if (!static::checkMy($action->id))
			throw new \yii\web\ForbiddenHttpException('Действие доступно только владельцу техкарты');

		return parent::beforeAction($action);
	}


	//-------------------------------------------------------------------------
	public function to($url = '')
	//-------------------------------------------------------------------------
	{
		if (!is_array($url))
			throw new \yii\web\NotFoundHttpException('Некорректное использование построителя ссылок!');

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
    public function getBreads()
	//-------------------------------------------------------------------------
    {

        $arrBreads = parent::getBreads();

        // Применить преобразование URL
        foreach ($arrBreads as $k => $sttBread) 
        	$arrBreads[$k]['url'] = $this->to($sttBread['url']);

        // Добавить ссылку на режим
        if ($this->id_mode)
        	array_unshift($arrBreads, ['label' => static::mode($this->id_mode), 'url' => ['/cards/list//index', 'id_mode' => $this->id_mode]]);

        return $arrBreads;
    }

}
