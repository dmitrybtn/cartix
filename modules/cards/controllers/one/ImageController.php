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
	public function actionUpload()
	//-------------------------------------------------------------------------
	{
		$arrErrors = [];

		$modNewImage = new CardImage;
		$modNewImage->id_card = $this->card->id;

		if (Yii::$app->request->post('url')) {

			$modNewImage->url = Yii::$app->request->post('url');

			if ($modNewImage->validate()) {
				$modNewImage->scenario = 'url';
				$modNewImage->file = UploadFromUrl::initWithUrl($modNewImage->url);

				if (!$modNewImage->save())
					$arrErrors[] = array_values($modNewImage->getFirstErrors())[0];

			} else $arrErrors[] = array_values($modNewImage->getFirstErrors())[0];

		} elseif ($arrFiles = UploadedFile::getInstancesByName('file')) {
			
			$notSaved = 0;

			foreach ($arrFiles as $objFile) {
				$modImage = new CardImage;
				$modImage->scenario = 'file';
				$modImage->id_card = $this->card->id;
				$modImage->file = $objFile; 

				if (!$modImage->save()) 
					$arrErrors[] = $objFile->name . ": " . array_values($modImage->getFirstErrors())[0];
			}	
		}

		Yii::$app->session->setFlash('image-upload', $arrErrors);	

		return $this->goReferrer();
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
