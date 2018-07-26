<?php

namespace app\tests\functional;

use app\models\Card;
use yii\helpers\Url;

class CardCest
{
	public $id_card;

    /**
     *
     */
	public function prepare(\FunctionalTester $I)
	{
        Card::deleteAll();	
	}

    /**
     *
     */
    public function create(\FunctionalTester $I)
    {
    	$I->amOnPage(['card/index']);
    	$I->click('Добавить');

    	$I->fillField('#card-name', 'Preved medved');
        $I->click('Сохранить', '#card-form');

        $I->expect('New record exists');
        $I->seeRecord(Card::className(), ['name' => 'Preved medved']);

        $I->expect('Redirect to view page');
        $I->seeInCurrentUrl('/card/view');

        $this->id_card = $I->grabRecord(Card::className(), ['name' => 'Preved medved'])->id;
    }

    /**
     *
     */
    public function update(\FunctionalTester $I)
    {
    	$I->amOnPage(['card/update', 'id' => $this->id_card]);

    	$I->fillField('#card-name', 'Preved medved 2');
        $I->click('Сохранить', '#card-form');

        $I->seeRecord(Card::className(), ['name' => 'Preved medved 2']);
        $I->seeInCurrentUrl('/card/view');
    }

    /**
     *
     */
    public function index(\FunctionalTester $I)
    {
    	$I->amOnPage(['card/index']);

    	$I->see('Preved medved');
    }

    /**
     *
     */
    public function delete(\FunctionalTester $I)
    {
		$I->amOnPage(['card/view', 'id' => $this->id_card]);
        $I->click('Удалить техкарту');

        $I->dontSeeRecord(Card::className(), ['name' => 'Preved medved 2']);
    }

}
