<?php

namespace app\models;

use Yii;

use dmitrybtn\cp\users\models\User;

//*****************************************************************************
class Card extends \yii\db\ActiveRecord
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
		$this->id_user = Yii::$app->user->id;
	}

	//-------------------------------------------------------------------------
	public function attributeLabels()
	//-------------------------------------------------------------------------
	{
		return [
			'name' => 'Наименование',
			'map' => 'Ссылка на карту',
		];
	}

	//-------------------------------------------------------------------------
	public function rules()
	//-------------------------------------------------------------------------
	{
		return [
			[['name'], 'required'],
			[['name'], 'unique', 'targetAttribute' => ['name', 'id_user']],
			[['name', 'map'], 'string', 'max' => 255],
			[['map'], 'url'],

			[['search_string'], 'safe', 'on' => 'search'],
		];
	}	

	//-------------------------------------------------------------------------
	public function beforeSave($insert)
	//-------------------------------------------------------------------------
	{
		if ($insert) {
			$this->secret = Yii::$app->security->generateRandomString(7);			
		}

		return parent::beforeSave($insert);
	}

	//-------------------------------------------------------------------------
	public function getSubscribe()
	//-------------------------------------------------------------------------
	{
		if ($this->_subscribe === null) {
			$this->_subscribe = CardSubscribe::findOne(['id_card' => $this->id, 'id_user' => Yii::$app->user->id]);

			if ($this->_subscribe === null)
				$this->_subscribe = false;
		}

		return $this->_subscribe;

	} private $_subscribe;


	//-------------------------------------------------------------------------
	public function subscribeToggle()
	//-------------------------------------------------------------------------
	{
		if ($this->subscribe === false) {

			$modSubscribe = new CardSubscribe;
			$modSubscribe->id_card = $this->id;
			$modSubscribe->id_user = Yii::$app->user->id;
			$modSubscribe->save();

		} else $this->subscribe->delete();

		$this->_subscribe = null;
	}

	//*************************************************************************
	// Связанные записи
	//*************************************************************************

	//-------------------------------------------------------------------------
	public function getUser()
	//-------------------------------------------------------------------------
	{
		return $this->hasOne(User::className(), ['id' => 'id_user']);
	}

	//-------------------------------------------------------------------------
	public function getTransfers()
	//-------------------------------------------------------------------------
	{
		return $this->hasMany(CardTransfer::className(), ['id_card' => 'id'])->inverseOf('card');
	}

	//-------------------------------------------------------------------------
	public function getImages($unlisted = false)
	//-------------------------------------------------------------------------
	{
		$objQuery = $this->hasMany(CardImage::className(), ['id_card' => 'id'])->inverseOf('card')->sorted();

		if ($unlisted)
			$objQuery = $objQuery->leftJoin('cards_objects_images', 'id_image = id')->where('id_object IS NULL');

		return $objQuery;
	}

	//-------------------------------------------------------------------------
	public function getImagesKeys()
	//-------------------------------------------------------------------------
	{
		if ($this->_imagesKeys === null)
			$this->_imagesKeys = $this->getImages()->select('id')->column();

		return $this->_imagesKeys;
		
	} private $_imagesKeys;	


	//*************************************************************************
	// Пользовательские методы
	//*************************************************************************

	//-------------------------------------------------------------------------
	public function getIsMy()
	//-------------------------------------------------------------------------
	{
		return $this->id_user == Yii::$app->user->id;
	}

	//-------------------------------------------------------------------------
	public function getSid()
	//-------------------------------------------------------------------------
	{
		return $this->secret . $this->id;
	}

	//-------------------------------------------------------------------------
	public function getTitle()
	//-------------------------------------------------------------------------
	{
		return $this->name;
	}

	//*************************************************************************
	// Поиск
	//*************************************************************************

	//-------------------------------------------------------------------------
	public function search()
	//-------------------------------------------------------------------------
	{
		$objQuery = self::find();

		// $objQuery->andFilterWhere(['like', '', $this->search_string]);

		return $objQuery;
	}

	public static function find() {return new CardQuery(get_called_class());}
	public static function tableName() {return 'cards';}
}


//*****************************************************************************
class CardQuery extends \yii\db\ActiveQuery
//*****************************************************************************
{
	//-------------------------------------------------------------------------
	public function bySid($sid)
	//-------------------------------------------------------------------------
	{
		return $this->andWhere(['id' => substr($sid, 7), 'secret' => substr($sid, 0, 7)]);
	}


	//-------------------------------------------------------------------------
	public function mode($id_mode)
	//-------------------------------------------------------------------------
	{
		switch ($id_mode) {
			case 'my':
				
				return $this->andWhere(['id_user' => Yii::$app->user->id]);

			case 'common':
				
				return $this->andWhere(['is_common' => 1]);

			case 'subscr':
				
				return $this->leftJoin('cards_subscribes', 'cards.id = cards_subscribes.id_card')->andWhere(['cards_subscribes.id_user' => Yii::$app->user->id]);
		}
	}

	//-------------------------------------------------------------------------
	public function sorted()
	//-------------------------------------------------------------------------
	{
		return $this->addOrderBy('name');
	}

}