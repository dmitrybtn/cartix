<?php

namespace app\modules\cards\controllers;

use Yii;

use app\modules\cards\models\Card;

use yii\helpers\{Url, Html};


//*****************************************************************************
class BaseController extends \dmitrybtn\cp\CrudController
//*****************************************************************************
{
	public $card;

	public $layout = '@app/modules/cards/views/layouts/layout';

	public $showPlan = false;
	public $showNavMobile = false;

	public $menuCard;

	//-------------------------------------------------------------------------
	public function init()
	//-------------------------------------------------------------------------
	{
		// Загрузить карту
		$this->card = Card::find()->bySid(Yii::$app->request->get('id_card'))->one();

		if ($this->card === null)
			throw new \yii\web\NotFoundHttpException('Карта не найдена!');

		// Открыть доступ для владельцев карт
		if ($this->card->isMy)
			Yii::$app->authManager->roles['user']['rights'][] = '/cards/owner/*';


		// Отключить хлебные крошки
        if (Yii::$app->user->isGuest)
        	$this->showBreads = false;


        $this->menuCard = [
	    	['label' => 'Опции техкарты'],
			['label' => 'Настройки', 'url' => $this->to(['/cards/owner/card/update'])],
			['label' => $this->card->isSubscr ? 'Отписаться' : 'Подписаться', 'url' => $this->to(['/cards/card/subscribe']), 'visible' => !$this->card->isMy],
			['label' => $this->card->is_common ? 'Убрать из базы' : 'Добавить в базу', 'url' => $this->to(['/cards/card/common'])],
			['label' => 'Удалить техкарту', 'url' => $this->to(['/cards/owner/card/delete']), 'linkOptions' => ['data' => ['confirm' => 'Точно?', 'method' => 'POST']]],
        ];
	}

	//-------------------------------------------------------------------------
	public function to($url)
	//-------------------------------------------------------------------------
	{
		$url['id_card'] = $this->card->sid;

		return $url;
	}

	//-------------------------------------------------------------------------
	public function a($text, $url = null, $options = [])
	//-------------------------------------------------------------------------
	{
		$url = $this->to($url);

		if (Yii::$app->user->can($url[0])) return Html::a($text, $url, $options);
		else return Html::tag('span', $text, $options);
	}

	//-------------------------------------------------------------------------
    public function getBreads()
	//-------------------------------------------------------------------------
    {
        if ($this->_breads === null) {
            $this->setBreads([
            	['label' => $this->card->title, 'url' => $this->to(['/cards/view/text'])],
            ]);        	
        }

        return $this->_breads;
    }


	//-------------------------------------------------------------------------
	public function getTransfers()
	//-------------------------------------------------------------------------
	{
		if ($this->_transfers === null)
			$this->_transfers = $this->card->getTransfers()
				->with('objects', 'objects.objectImages', 'objects.objectImages.image')
				->sorted()
				->all();
		
		return $this->_transfers;

	} private $_transfers;

}
