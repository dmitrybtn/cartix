<?php

namespace app\modules\cards\controllers;

use Yii;

use app\modules\cards\models\{Card, CardLog};

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
	
	public $menuNav;
	public $menuNavMobile;

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

        $this->menuNav =  [
	    	['label' => 'Навигация'],
			['label' => 'План', 'url' => $this->to(['/cards/view/plan'])],
			['label' => 'Текст', 'url' => $this->to(['/cards/view/text'])],
			['label' => 'Картинки', 'url' => $this->to(['/cards/view/images'])],
			['label' => 'Цитаты', 'url' => $this->to(['/cards/view/quotes'])],
	    ];

        $this->menuNavMobile = [
	        ['label' => '<span class="glyphicon glyphicon-th-list"></span>', 'url' => $this->to(['/cards/view/plan'])],
	        ['label' => '<span class="glyphicon glyphicon-text-size"></span>', 'url' => $this->to(['/cards/view/text'])],
	        ['label' => '<span class="glyphicon glyphicon-picture"></span>', 'url' => $this->to(['/cards/view/images'])],
	        ['label' => '<span class="glyphicon glyphicon-bullhorn"></span>', 'url' => $this->to(['/cards/view/quotes'])],
	        ['label' => '<span class="glyphicon glyphicon-cog"></span>', 'url' => $this->to(['/cards/view/options'])],
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


	//-------------------------------------------------------------------------
	public function beforeAction($action)
	//-------------------------------------------------------------------------
	{
	    if (!parent::beforeAction($action))
	        return false;

	    if (Yii::$app->user->id != 1) {
	    	$modLog = new CardLog;
	    	$modLog->id_card = $this->card->id;
	    	$modLog->route = $action->uniqueId;
	    	$modLog->save();	    	
	    }


	    return true;
	}
}
