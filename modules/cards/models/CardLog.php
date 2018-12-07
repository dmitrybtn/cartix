<?php

namespace app\modules\cards\models;

use Yii;

use app\modules\users\models\User;
use Detection\MobileDetect;

//*****************************************************************************
class CardLog extends \yii\db\ActiveRecord
//*****************************************************************************
{
	public $search_string;

	//*************************************************************************
	// AR - методы
	//*************************************************************************

	//-------------------------------------------------------------------------
	public function init()
	//-------------------------------------------------------------------------
	{
		$this->timestamp = time();
		$this->ip = Yii::$app->request->userIp;
		$this->agent = Yii::$app->request->userAgent;

		$objDetect = new MobileDetect;

		if ($objDetect->isMobile()) $this->device = 'mobile';
		elseif ($objDetect->isTablet()) $this->device = 'tablet';
		else $this->device = 'desktop';

		if (!Yii::$app->user->isGuest) 
			$this->id_user = Yii::$app->user->id;
	}

	//-------------------------------------------------------------------------
	public function attributeLabels()
	//-------------------------------------------------------------------------
	{
		return [
			'id' => 'ID',
			'id_card' => 'Id Card',
			'id_user' => 'Id User',
			'timestamp' => 'Timestamp',
			'route' => 'Route',
		];
	}

	//-------------------------------------------------------------------------
	public function rules()
	//-------------------------------------------------------------------------
	{
		return [
			[['search_string'], 'safe', 'on' => 'search'],
		];
	}	
	//*************************************************************************
	// Связанные записи
	//*************************************************************************


	//-------------------------------------------------------------------------
	public function getCard()
	//-------------------------------------------------------------------------
	{
		return $this->hasOne(Card::className(), ['id' => 'id_card']);
	}

	//-------------------------------------------------------------------------
	public function getUser()
	//-------------------------------------------------------------------------
	{
		return $this->hasOne(User::className(), ['id' => 'id_user']);
	}

	//*************************************************************************
	// Пользовательские методы
	//*************************************************************************

	//-------------------------------------------------------------------------
	public function getTitle()
	//-------------------------------------------------------------------------
	{
		return $this->id;
	}

	//*************************************************************************
	// Поиск
	//*************************************************************************

	//-------------------------------------------------------------------------
	public function search()
	//-------------------------------------------------------------------------
	{
		$objQuery = self::find();
		$objQuery->with = ['card', 'user'];
		$objQuery->orderBy = ['timestamp' => SORT_DESC];

		$objQuery->orFilterWhere(['like', 'ip', $this->search_string]);

		return $objQuery;
	}

	public static function find() {return new CardLogQuery(get_called_class());}
	public static function tableName() {return 'cards_logs';}
}


//*****************************************************************************
class CardLogQuery extends \yii\db\ActiveQuery
//*****************************************************************************
{
}