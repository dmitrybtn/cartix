<?php

namespace app\models;

use Yii;
use dmitrybtn\cp\SortBehavior;

use igogo5yo\uploadfromurl\FileFromUrlValidator;
use igogo5yo\uploadfromurl\UploadFromUrl;

use yii\helpers\FileHelper;
use yii\web\UploadedFile;

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
			['file', FileFromUrlValidator::className(), 'mimeTypes' => 'image/*', 'on' => 'url'],
			['file', 'file', 'mimeTypes' => 'image/*', 'on' => 'file'],


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

	//-------------------------------------------------------------------------
	public function beforeSave($insert)
	//-------------------------------------------------------------------------
	{
		if ($insert)
			$this->upload();		

		return parent::beforeSave($insert);
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

	//-------------------------------------------------------------------------
	public function upload()
	//-------------------------------------------------------------------------
	{
		if ($this->file instanceof UploadedFile) $src = $this->file->tempName;
		elseif ($this->file instanceof UploadFromUrl) $src = $this->file->url;
		
		$name = sprintf('%x', crc32(file_get_contents($src))) . $this->file->size . '.' . $this->file->extension;

		$dir = $name[3];
		$url = $dir . '/' . $name;

		FileHelper::createDirectory(Yii::getAlias('@webroot/uploads/' . $dir), 0777);

		if ($this->file->saveAs(Yii::getAlias('@webroot/uploads') . '/' . $url))
			$this->file = $url;
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
