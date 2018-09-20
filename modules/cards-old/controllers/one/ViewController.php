<?php

namespace app\modules\cards\controllers\one;

use Yii;

use app\modules\cards\models\Card;
use app\modules\cards\models\CardImage;

use yii\helpers\Url;

//*****************************************************************************
class ViewController extends \app\modules\cards\controllers\BaseController
//*****************************************************************************
{

	public $showHeader = false;

	//-------------------------------------------------------------------------
	public function init()
	//-------------------------------------------------------------------------
	{
		parent::init();

		$this->model = $this->card;
	}

	//-------------------------------------------------------------------------
	public static function needMy()
	//-------------------------------------------------------------------------
	// Возвращает true если для выполнения действия нужно быть владельцем карты
	{
		return false;
	}

	//-------------------------------------------------------------------------
	public static function title($actionId, $modCard = null)
	//-------------------------------------------------------------------------
	{
		return $modCard->name;
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
	public function actionPlan()
	//-------------------------------------------------------------------------
	{
		$this->menu = [
			['label' => 'Опции'],
			['label' => TransferController::title('create'), 'url' => $this->to(['/cards/one/transfer/create']), 'visible' => TransferController::checkMy('create')],
			['label' => CardController::title('update'), 'url' => $this->to(['/cards/one/card/update']), 'visible' => CardController::checkMy('update')],
			['label' => CardController::title('delete'), 'url' => $this->to(['/cards/one/card/delete']), 'linkOptions' => ['data' => ['confirm' => 'Точно?', 'method' => 'POST']], 'visible' => CardController::checkMy('delete')],


			['label' => $this->card->is_common ? 'Убрать из базы' : 'Добавить в базу', 'url' => $this->to(['/cards/admin//common'])],

			['label' => $this->card->subscribe ? 'Отписаться' : 'Подписаться', 'url' => $this->to(['/cards/one/card/subscribe']), 'visible' => !$this->card->isMy],

		];

		return $this->render('@app/modules/cards/views/one/view-plan.php');
	}


	//-------------------------------------------------------------------------
	public function actionText()
	//-------------------------------------------------------------------------
	{
		return $this->render('@app/modules/cards/views/one/view-text.php');
	}


	//-------------------------------------------------------------------------
	public function actionImages()
	//-------------------------------------------------------------------------
	{
		return $this->render('@app/modules/cards/views/one/view-images.php');
	}

}
