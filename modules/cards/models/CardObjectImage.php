<?php

namespace app\modules\cards\models;

use Yii;
use dmitrybtn\sort\SortBehavior;

//*****************************************************************************
class CardObjectImage extends \yii\db\ActiveRecord
//*****************************************************************************
{

	public function getImage()
	{
		return $this->hasOne(CardImage::className(), ['id' => 'id_image']);
	}

	public static function tableName() {return 'cards_objects_images';}
}