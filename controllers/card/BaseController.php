<?php

namespace app\controllers\card;

use Yii;

use app\models\Card;

use yii\helpers\Url;


//*****************************************************************************
class BaseController extends \dmitrybtn\cp\Controller
//*****************************************************************************
{
	//-------------------------------------------------------------------------
	public function to($url = '')
	//-------------------------------------------------------------------------
	{
		if (!is_array($url))
			throw new \yii\web\NotFoundHttpException('Некорректное использование построителя ссылок!');

		$url[0] = '/card/' . ltrim($url[0], '/');

		$url['id_card'] = $this->card->id;
		$url['id_mode'] = $this->id_mode;

		return $url;
	}

	//-------------------------------------------------------------------------
	public function getId_mode()
	//-------------------------------------------------------------------------
	{
		return Yii::$app->request->get('id_mode');
	}

	//-------------------------------------------------------------------------
	public function getCard()
	//-------------------------------------------------------------------------
	{
		if ($this->_card === null) {
			
			$id = Yii::$app->request->get('id_card');

			if (($this->_card = Card::findOne($id)) === null)
				throw new \yii\web\NotFoundHttpException('Карта не найдена!');
		}

		return $this->_card;

	} private $_card;


	//-------------------------------------------------------------------------
	public static function mode($id_mode)
	//-------------------------------------------------------------------------
	{
		return [
			'my' => 'Мои техкарты',
			'common' => 'Общие',
			'subscr' => 'Мои подписки',
		][$id_mode];
	}

	//-------------------------------------------------------------------------
    public function getBreads()
	//-------------------------------------------------------------------------
    {
        if ($this->_breads === null) {
            
			$r = [];

			if ($this->id_mode)
				$r[] = ['label' => static::mode($this->id_mode), 'url' => ['/card/list/index', 'id_mode' => $this->id_mode]];

            $this->setBreads($r);
        }

        return $this->_breads;
    } 
}
