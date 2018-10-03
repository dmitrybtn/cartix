<?php

namespace app\modules\cards\models;

use Yii;

//*****************************************************************************
class CardViewer extends \yii\db\ActiveRecord
//*****************************************************************************
{
	//-------------------------------------------------------------------------
	public function init()
	//-------------------------------------------------------------------------
	{
		$this->id_user = Yii::$app->user->id;
	}

	public static function find() {return new CardUserQuery(get_called_class());}
	public static function tableName() {return 'cards_viewers';}
}


//*****************************************************************************
class CardUserQuery extends \yii\db\ActiveQuery
//*****************************************************************************
{
}
