<?php

namespace app\models;

use Yii;
use dmitrybtn\cp\SortBehavior;

//*****************************************************************************
class CardObjectImage extends \yii\db\ActiveRecord
//*****************************************************************************
{

	public static function tableName() {return 'cards_objects_images';}
}