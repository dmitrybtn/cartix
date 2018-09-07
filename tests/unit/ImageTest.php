<?php

namespace app\tests\unit;

use Yii;
use app\models\CardImage;
use yii\helpers\FileHelper;

class ImageTest extends \Codeception\Test\Unit
{

	public function testExtract()
	{
		$arrImages = CardImage::extract('Превед [Ф-1] [Ф-2569], медвед [Ф-2] йа креведко');

		$this->assertEquals([1 => '', 2569 => '', 2 => ''], $arrImages);
	}

	/*
	public function testExtractMerged()
	{
		$arrImages = CardImage::extract('Превед [Ф-1][Ф-258], медвед [Ф-1] йа [Ф-5] креведко [Ф-258]', true);

		$this->assertEquals([1, 258, 5], $arrImages);
	}
	*/
}