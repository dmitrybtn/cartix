<?php

namespace app\tests\unit;

use Yii;
use app\models\CardImage;
use yii\helpers\FileHelper;

class ImageTest extends \Codeception\Test\Unit
{

	public function _before()
	{
		FileHelper::createDirectory(Yii::getAlias('@webroot/uploads/t'));
		
		copy(Yii::getAlias('@app/tests/_data/test.jpg'), Yii::getAlias('@webroot/uploads/t/test.jpg'));
	}


	public function testInitial()
	{
		/*
		$objImage = new CardImage;
		$objImage->image = 't/image.jpg'; 
		*/
	}
	
}