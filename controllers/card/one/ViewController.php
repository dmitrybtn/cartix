<?php

namespace app\controllers\card\one;

use Yii;

use app\models\Card;
use app\models\CardImage;

use yii\helpers\Url;

use igogo5yo\uploadfromurl\UploadFromUrl;
use yii\web\UploadedFile;


//*****************************************************************************
class ViewController extends \app\controllers\card\BaseController
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
				$breads[] = ['label' => static::title('view', $modCard), 'url' => ['/card/one/view/plan']];				
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
			['label' => CardController::title('update'), 'url' => $this->to(['/card/one/card/update']), 'visible' => $this->checkCard()],
			['label' => CardController::title('delete'), 'url' => $this->to(['/card/one/card/delete']), 'linkOptions' => ['data' => ['confirm' => 'Точно?', 'method' => 'POST']], 'visible' => $this->checkCard()],


			['label' => $this->card->is_common ? 'Убрать из базы' : 'Добавить в базу', 'url' => $this->to(['/card/admin/common'])],

			['label' => $this->card->subscribe ? 'Отписаться' : 'Подписаться', 'url' => $this->to(['/card/one/card/subscribe']), 'visible' => !Yii::$app->user->isGuest && !$this->checkCard()],

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
	public function actionImages()
	//-------------------------------------------------------------------------
	{
		$modNewImage = new CardImage;
		$modNewImage->id_card = $this->card->id;

		if (Yii::$app->request->post('url')) {
			$modNewImage->url = Yii::$app->request->post('url');

			if ($modNewImage->validate()) {
				$modNewImage->scenario = 'url';
				$modNewImage->file = UploadFromUrl::initWithUrl($modNewImage->url);

				if ($modNewImage->save())
					return Yii::$app->getResponse()->redirect($this->getReferrer(), 302, false);
			}
		} elseif ($arrFiles = UploadedFile::getInstancesByName('file')) {
			
			$notSaved = 0;

			foreach ($arrFiles as $objFile) {
				$modImage = new CardImage;
				$modImage->id_card = $this->card->id;
				$modImage->file = $objFile; 

				if (!$modImage->save()) $notSaved++;
			}

			if ($notSaved)
				Yii::$app->session->addFlash('error', "Не удалось загрузить $notSaved изображений");

			return Yii::$app->getResponse()->redirect($this->getReferrer(), 302, false);
		}

		$this->title = $this->card->name;

		$this->menu = [
			['label' => 'Опции'],
		];

		return $this->render('@app/views/card/one/view-images.php', ['modNewImage' => $modNewImage]);
	}

}
