<?php

namespace app\modules\cards\models;

use Yii;

//*****************************************************************************
class CardViewing extends \yii\db\ActiveRecord
//*****************************************************************************
{

	//-------------------------------------------------------------------------
	public function init()
	//-------------------------------------------------------------------------
	{
		$this->id_user = Yii::$app->user->id;
		$this->timestamp = time();
	}


	public static function find() {return new CardViewingQuery(get_called_class());}
	public static function tableName() {return 'cards_viewings';}
}


//*****************************************************************************
class CardViewingQuery extends \yii\db\ActiveQuery
//*****************************************************************************
{
}
