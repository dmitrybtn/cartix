<?php

namespace app\tests\unit;

use Yii;
use app\models\CardImage;
use yii\helpers\FileHelper;

class ImageTest extends \Codeception\Test\Unit
{

	public function testExtract()
	{
		$arrImages = CardImage::extract('Превед ФОТО-1ФОТО-2569, медвед ФОТО-2 йа креведко');

		$this->assertEquals([1, 2569, 2], $arrImages);
	}


	public function testExtractMerged()
	{
		$arrImages = CardImage::extract('Превед ФОТО-1ФОТО-258, медвед ФОТО-1 йа ФОТО-5 креведко ФОТО-258', true);

		$this->assertEquals([1, 258, 5], $arrImages);
	}
	
}