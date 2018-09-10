<?php

namespace app\controllers\card;

use Yii;

use app\models\Card;

//*****************************************************************************
class ListController extends \dmitrybtn\cp\CrudController
//*****************************************************************************
{

	public $id_mode;


	//-------------------------------------------------------------------------
	public function init()
	//-------------------------------------------------------------------------
	{	
		$this->id_mode = Yii::$app->request->get('id_mode');
	}


	public static function modes($id_mode = null)
	{
		$arrModes = [
			'my' => 'Мои техкарты',
			'common' => 'Общие',
			'subscr' => 'Мои подписки',
		];

		return $id_mode ? $arrModes[$id_mode] : $arrModes;
	}

	public function getTitle()
	{		
		return [
			'index' => static::modes($this->id_mode),
			'create' => 'Создать техкарту',
		][$this->action->id];
	}

	//-------------------------------------------------------------------------
	public function actionIndex($ss = '')
	//-------------------------------------------------------------------------
	{
		$this->model = new Card(['scenario' => 'search']);
		$this->model->search_string = $ss;

		$this->showBreads = false;

		$this->menu = [
			['label' => 'Опции'],
			['label' => self::title('create'), 'url' => ['create']],
		];
		
		return $this->render('@app/views/card/list.php');
	}
}
