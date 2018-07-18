<?php

namespace app\models;

use Yii;
use dmitrybtn\cp\SortBehavior;

//*****************************************************************************
class CardObject extends \yii\db\ActiveRecord
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
			'time' => 'Время (мин)',
			'name' => 'Наименование объекта',
			'instruction' => 'Методические указания',
			'text' => 'Информационная справка',
		];
	}

	//-------------------------------------------------------------------------
	public function rules()
	//-------------------------------------------------------------------------
	{
		return [
			[['name'], 'required'],
			[['time'], 'integer'],
			[['instruction', 'text'], 'string'],
			[['name'], 'string', 'max' => 255],

			[['id_transfer'], 'exist', 'skipOnError' => true, 'targetClass' => CardTransfer::className(), 'targetAttribute' => ['id_transfer' => 'id']],

			[['search_string'], 'safe', 'on' => 'search'],
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
				'group' => 'id_transfer',
			]
		];
	}

	//-------------------------------------------------------------------------
	public function afterSave($insert, $changedAttributes)
	//-------------------------------------------------------------------------
	{
		// if (isset($changedAttributes['text']))
			$this->saveImages();

		return parent::afterSave($insert, $changedAttributes);
	}

	//*************************************************************************
	// Связанные записи
	//*************************************************************************

	//-------------------------------------------------------------------------
	public function getCard()
	//-------------------------------------------------------------------------
	{
		return $this->transfer->card;
	}

	//-------------------------------------------------------------------------
	public function getTransfer()
	//-------------------------------------------------------------------------
	{
		return $this->hasOne(CardTransfer::className(), ['id' => 'id_transfer']);
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

	protected function getCardImageKeys()
	{
		return $this->card->getImages()->select('id')->column();
	}

	//-------------------------------------------------------------------------
	public function saveImages()
	//-------------------------------------------------------------------------
	{
		CardObjectImage::deleteAll(['id_object' => $this->id]);

		$arrCardImages = $this->getCardImageKeys();

		foreach (CardImage::extract($this->text) as $id_sort => $id_image) {

			if (in_array($id_image, $arrCardImages)) {
				$modObjectImage = new CardObjectImage;
				$modObjectImage->id_object = $this->id;
				$modObjectImage->id_image = $id_image;
				$modObjectImage->id_sort = $id_sort;
				$modObjectImage->save();
			}
		}
	}


	//-------------------------------------------------------------------------
	public function getTextParsed()
	//-------------------------------------------------------------------------
	{
		$arrCardImages = $this->getCardImageKeys();

		$arrSearch = [];
		$arrReplace = [];

		foreach (CardImage::extract($this->text, true) as $id_image) {
			$arrSearch[] = CardImage::marker($id_image);
			$arrReplace[] = in_array($id_image, $arrCardImages) ? 'НОРМ' : 'ХУЙ';
		}

		return str_replace($arrSearch, $arrReplace, $this->text);		
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

	public static function find() {return new CardObjectQuery(get_called_class());}
	public static function tableName() {return 'cards_objects';}
}


//*****************************************************************************
class CardObjectQuery extends \yii\db\ActiveQuery
//*****************************************************************************
{
	//-------------------------------------------------------------------------
	public function sorted()
	//-------------------------------------------------------------------------
	{
		return $this->addOrderBy('id_sort');
	}
}
