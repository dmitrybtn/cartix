<?php

namespace app\models;

use Yii;

//*****************************************************************************
class Card extends \yii\db\ActiveRecord
//*****************************************************************************
{
	public $search_string;

	//*************************************************************************
	// AR - методы
	//*************************************************************************

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
			[['name', 'map'], 'string', 'max' => 255],
			[['map'], 'url'],

			[['search_string'], 'safe', 'on' => 'search'],
		];
	}	
	//*************************************************************************
	// Связанные записи
	//*************************************************************************

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
	public function sorted()
	//-------------------------------------------------------------------------
	{
		return $this->addOrderBy('name');
	}

}
