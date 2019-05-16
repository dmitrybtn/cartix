<?php

namespace app\modules\cards\models;

use Yii;
use dmitrybtn\sort\SortBehavior;
use yii\helpers\Html;
use darkdrim\simplehtmldom\SimpleHTMLDom;

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
			'annotation' => 'Аннотация',
			'text' => 'Рассказ',
		];
	}

	//-------------------------------------------------------------------------
	public function rules()
	//-------------------------------------------------------------------------
	{
		return [
			[['name'], 'required'],
			[['time'], 'integer'],
			[['annotation', 'text'], 'string'],
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
	public function beforeSave($insert)
	//-------------------------------------------------------------------------
	{
		$this->size = mb_strlen(strip_tags($this->text), 'utf8');

		return parent::beforeSave($insert);
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
		return $this->hasOne(CardTransfer::className(), ['id' => 'id_transfer'])->inverseOf('objects');
	}

	//-------------------------------------------------------------------------
	public function getObjectImages()
	//-------------------------------------------------------------------------
	{
		return $this->hasMany(CardObjectImage::className(), ['id_object' => 'id'])->orderBy('id_sort')->with('image');
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

	//-------------------------------------------------------------------------
	public function saveImages()
	//-------------------------------------------------------------------------
	{
		CardObjectImage::deleteAll(['id_object' => $this->id]);

		$arrCardImages = $this->card->getImagesKeys();

		$id_sort = 0;
		foreach (CardImage::extract($this->text) as $id_image => $comment) {

			if (in_array($id_image, $arrCardImages)) {
				$modObjectImage = new CardObjectImage;
				$modObjectImage->id_object = $this->id;
				$modObjectImage->id_image = $id_image;
				$modObjectImage->id_sort = $id_sort;
				$modObjectImage->comment = $comment;
				$modObjectImage->save();

				$id_sort++;
			}
		}
	}


	//-------------------------------------------------------------------------
	public function getTextParsed()
	//-------------------------------------------------------------------------
	{
		return CardImage::replace($this->text, $this->card->getImagesKeys(), Html::a('$0', '#', ['class' => 'photoswipe']), Html::tag('span', '$0', ['class' => 'text-danger']));
	}


	//-------------------------------------------------------------------------
	public function getQuotes()
	//-------------------------------------------------------------------------
	{
		if ($this->_quotes === null) {

			$this->_quotes = [];

			if ($objDom = (new SimpleHTMLDom)->str_get_html($this->text)) {
				foreach ($objDom->find('blockquote') as $objNode) {
					$this->_quotes[] = $objNode->outertext;
				}
			}
		}

		return $this->_quotes;

	} private $_quotes;

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
