<?php

namespace app\tests\unit;

use Yii;
use app\modules\cards\models\CardImage;
use yii\helpers\FileHelper;

class ImageTest extends \Codeception\Test\Unit
{

	public function testExtract()
	{
		$arrImages = CardImage::extract('Превед [Ф-1] [Ф-2569, комментарий], медвед [Ф-2 текст] йа креведко');

		$this->assertEquals([1 => '', 2569 => 'комментарий', 2 => 'текст'], $arrImages);
	}

	public function testReplace()
	{
		$strText = CardImage::replace('Превед [Ф-1] [Ф-2], медвед [Ф-3] йа креведко', [1, 3], 'S$0S', 'E$0E');

		$this->assertEquals('Превед S[Ф-1]S E[Ф-2]E, медвед S[Ф-3]S йа креведко', $strText);
	}
}