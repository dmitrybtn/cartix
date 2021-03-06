<?php

namespace app\modules\cards\models;

use Yii;
use dmitrybtn\sort\SortBehavior;

use igogo5yo\uploadfromurl\FileFromUrlValidator;
use igogo5yo\uploadfromurl\UploadFromUrl;

use yii\helpers\FileHelper;

use yii\web\UploadedFile;
use yii\imagine\Image;

//*****************************************************************************
class CardImage extends \yii\db\ActiveRecord
//*****************************************************************************
{
	public $search_string;

	public const MARKER = 'Ф';

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

			['file', FileFromUrlValidator::className(), 'mimeTypes' => 'image/*', 'on' => 'url', 'wrongMimeType' => 'Не очень похоже на картинку...'],
			['file', 'file', 'mimeTypes' => 'image/*', 'on' => 'file', 'wrongMimeType' => 'Не очень похоже на картинку...'],
			['file', 'required', 'message' => 'Укажите либо URL, либо файл. Ну хоть что-нибудь!', 'on' => ['file', 'url']],


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
		if ($insert) {
			$this->upload();

			$p = getimagesize(Yii::getAlias('@webroot/uploads/' . $this->file));

			$this->width = $p[0];
			$this->height = $p[1];
		}

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

	//-------------------------------------------------------------------------
	public function thumbnail($width, $height)
	//-------------------------------------------------------------------------
	{
		$p = pathinfo($this->file); 

		$dir = $p['dirname'];
		$file = $dir . '/' . $p['filename'] . '-' . $width . 'x' . $height . '.jpg';

		if (!is_file(Yii::getAlias('@webroot/assets/thumbnails/' . $file))) {

			FileHelper::createDirectory(Yii::getAlias('@webroot/assets/thumbnails/' . $dir), 0777);

			$objThumb = Image::thumbnail('@webroot/uploads/' . $this->file, $width, $width);
			$objThumb->save(Yii::getAlias('@webroot/assets/thumbnails/' . $file), ['quality' => 80]);

		}

		return Yii::getAlias('@web/assets/thumbnails/' . $file);
	}

	//-------------------------------------------------------------------------
	public function getSize()
	//-------------------------------------------------------------------------
	{
		return $this->width . 'x' . $this->height;
	}

	//-------------------------------------------------------------------------
	public function getMarker()
	//-------------------------------------------------------------------------
	{
		return static::marker($this->id);
	}

	//-------------------------------------------------------------------------
	public static function marker($id)
	//-------------------------------------------------------------------------
	{
		return '[' . self::MARKER . '-' . $id . ']';
	}

	//-------------------------------------------------------------------------
	public static function extract($strText)
	//-------------------------------------------------------------------------
	{
		$r = [];

		$cnt = preg_match_all('/\[' . self::MARKER . '-(\d+)([,\s]+(.+))?\]/uU', $strText, $arrMatches);

		for ($i = 0; $i < $cnt; $i++)
			$r[$arrMatches[1][$i]] = trim($arrMatches[3][$i]);

		return $r;
	}

	//-------------------------------------------------------------------------
	public static function replace($strText, $ids, $success, $error)
	//-------------------------------------------------------------------------
	// Заменяет маркеры для картинок, указанных в ids на строку success, а остальные на error
	{
		return preg_replace_callback(
			'/\[' . self::MARKER . '-(\d+)([,\s]+(.+))?\]/uU',
			function($m) use($ids, $success, $error) {
				return preg_replace('/\[' . self::MARKER . '-(\d+)([,\s]+(.+))?\]/uU', (in_array($m[1], $ids) ? $success : $error), $m[0]);
			}, 
			$strText);
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
		return $this->addOrderBy('id');
	}
}
