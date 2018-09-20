<?php

namespace app\modules\cards\models;

use Yii;

//*****************************************************************************
class CardSubscribe extends \yii\db\ActiveRecord
//*****************************************************************************
{
	public $search_string;

	public static function find() {return new CardSubscribeQuery(get_called_class());}
	public static function tableName() {return 'cards_subscribes';}
}


//*****************************************************************************
class CardSubscribeQuery extends \yii\db\ActiveQuery
//*****************************************************************************
{
}
