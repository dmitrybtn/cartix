<?php

namespace app\tests\functional;

use app\models\{Card, CardTransfer, CardObject};

class CardBase
{
	public $id_card;
    public $id_transfer;
    public $id_object;

    /**
     *
     */
	protected function clear(\FunctionalTester $I)
	{
        Card::deleteAll();
	}

    /**
     *
     */
    protected function createCard(\FunctionalTester $I)
    {
    	$I->amOnPage(['card/index']);
    	$I->click('Добавить');

    	$I->fillField('#card-name', 'New card');
        $I->click('Сохранить', '#card-form');

        $I->expect('New record exists');
        $I->seeRecord(Card::className(), ['name' => 'New card']);

        $I->expect('Redirect to view page');
        $I->seeInCurrentUrl('/card/view');

        $this->id_card = $I->grabRecord(Card::className(), ['name' => 'New card'])->id;
    }


    /**
     * Проверяется только запись в базе и редирект, отображение должно проверяться на странице view
     */
    protected function createTransfer(\FunctionalTester $I)
    {
        $I->amOnPage(['card/view', 'id' => $this->id_card]);
        $I->click('Добавить остановку');

        $I->fillField('#cardtransfer-name', 'New transfer');
        $I->click('Сохранить', '#card-transfer-form');

        $I->seeRecord(CardTransfer::className(), ['name' => 'New transfer']);

        $I->seeInCurrentUrl('/card/view');

        $this->id_transfer = $I->grabRecord(CardTransfer::className(), ['name' => 'New transfer'])->id;
    }

    /**
     *
     */
    protected function createObject($I)
    {
        $this->openCard($I);

        $I->click('a.create', "tr[data-transfer-key=$this->id_transfer]");
        
        $I->fillField('#cardobject-name', 'New object');
        
        $I->click('Сохранить', '#card-object-form');
        $I->seeRecord(CardObject::className(), ['name' => 'New object']);

        $this->id_object = $I->grabRecord(CardObject::className(), ['name' => 'New object'])->id;        
    }


    protected function openCard($I, $action = 'view')
    {
        $I->amOnPage(['card/' . $action, 'id' => $this->id_card]);
    }
}
