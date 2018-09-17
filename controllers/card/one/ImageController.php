<?php

namespace app\controllers\card\one;

use Yii;
use dmitrybtn\cp\SortAction;
use app\models\CardImage;
use igogo5yo\uploadfromurl\UploadFromUrl;
use yii\web\UploadedFile;

//*****************************************************************************
class ImageController extends \app\controllers\card\BaseController
//*****************************************************************************
{
	//-------------------------------------------------------------------------
	public function actions()
	//-------------------------------------------------------------------------
	{
		return [
			'sort' => [
				'class' => SortAction::class,
			]
		];
	}

	//-------------------------------------------------------------------------
	public function actionView()
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
				$modImage->id_card = $id;
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



	//-------------------------------------------------------------------------
	public function actionDelete($id)
	//-------------------------------------------------------------------------
	{
		if (Yii::$app->request->isPost || YII_ENV_TEST) {
			try {		

				$this->find($id)->delete();
				return Yii::$app->getResponse()->redirect($this->getReferrer(), 302, false);

			} catch (\Exception $e) {

				Yii::$app->session->setFlash('error', $e->getMessage());
				return Yii::$app->getResponse()->redirect($this->getReferrer());

			}		
		} throw new \yii\web\MethodNotAllowedHttpException('Неверный формат запроса!');
	}

	//-------------------------------------------------------------------------
	public function find($id)
	//-------------------------------------------------------------------------
	{
		if (($modCardImage = CardImage::findOne($id)) !== null) return $modCardImage;
		else throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
	}
}
