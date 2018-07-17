<?php

namespace app\models;

use Yii;
use dmitrybtn\cp\SortBehavior;

//*****************************************************************************
class CardImage extends \yii\db\ActiveRecord
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
			'id' => 'ID',
			'id_card' => 'Id Card',
			'id_sort' => 'Id Sort',
			'name' => 'Name',
			'url' => 'Url',
			'file' => 'File',
			'description' => 'Description',
		];
	}

	//-------------------------------------------------------------------------
	public function rules()
	//-------------------------------------------------------------------------
	{
		return [
			
			[['url'], 'url'],


			/*
			[['id_card', 'id_sort', 'name', 'url', 'file', 'description'], 'required'],
			[['id_card', 'id_sort'], 'integer'],
			[['description'], 'string'],
			[['name', 'url', 'file'], 'string', 'max' => 255],
			[['id_card'], 'exist', 'skipOnError' => true, 'targetClass' => Card::className(), 'targetAttribute' => ['id_card' => 'id']],

			[['search_string'], 'safe', 'on' => 'search'],
			*/
		];
	}	
	
	//-------------------------------------------------------------------------
	public function behaviors()
	//-------------------------------------------------------------------------
	{
		return [
			'sort' => [
				'class' => SortBehavior::class,
				'attribute' => 'id_sort',
				'group' => 'id_card',
			]
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

	public static function find() {return new CardImageQuery(get_called_class());}
	public static function tableName() {return 'cards_images';}
}


//*****************************************************************************
class CardImageQuery extends \yii\db\ActiveQuery
//*****************************************************************************
{
	//-------------------------------------------------------------------------
	public function sorted()
	//-------------------------------------------------------------------------
	{
		return $this->addOrderBy('id_sort');
	}
}
