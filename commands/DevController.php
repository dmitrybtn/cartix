<?php

namespace app\commands;

use Yii;
use yii\console\ExitCode;
use yii\helpers\Console;

class DevController extends \yii\console\Controller
{
	public function actionRun()
	{
		$arrCards = \app\models\Card::find()->all();

		foreach ($arrCards as $modCard) {
			
			$modCard->secret = Yii::$app->security->generateRandomString(7);
			
			if (!$modCard->save())
				print_r($modCard->getErrors());

			//echo($modCard->save());
		}
	}




}