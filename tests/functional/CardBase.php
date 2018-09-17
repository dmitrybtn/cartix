<?php

namespace app\tests\functional;

use app\models\{Card, CardTransfer, CardObject};
use app\tests\fixtures\UsersFixture;

class CardBase
{
	public $id_card;
    public $id_transfer;
    public $id_object;


    public function _before(\FunctionalTester $I)
    {
        $I->haveFixtures([
            'users' => UsersFixture::className(),
        ]);

        $I->amLoggedInAs($I->grabFixture('users', 'root')->id);
    }


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
    	$I->amOnPage(['cards/index', 'id_mode' => 'my']);
    	$I->click('Добавить техкарту');

    	$I->fillField('#card-name', 'New card');
        $I->click('Сохранить', '#card-form');

        $I->expect('New record exists');
        $I->seeRecord(Card::className(), ['name' => 'New card']);

        $this->id_card = $I->grabRecord(Card::className(), ['name' => 'New card'])->sid;

        $I->expect('Redirect to view page');
        $I->seeInCurrentUrl('/cards/' . $this->id_card);
    }


    /**
     * Проверяется только запись в базе и редирект, отображение должно проверяться на странице view
     */
    protected function createTransfer(\FunctionalTester $I)
    {
        $this->openCard($I);

        $I->click('Добавить остановку');

        $I->fillField('#cardtransfer-name', 'New transfer');
        $I->click('Сохранить', '#card-transfer-form');

        $I->seeRecord(CardTransfer::className(), ['name' => 'New transfer']);

        $I->expect('Redirect to view page');
        $I->seeInCurrentUrl('/cards/' . $this->id_card);

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

        $I->expect('Redirect to view page');
        $I->seeInCurrentUrl('/cards/' . $this->id_card);

        $this->id_object = $I->grabRecord(CardObject::className(), ['name' => 'New object'])->id;        
    }


    protected function openCard($I, $action = 'plan', $id_mode = null)
    {
        $I->amOnPage(['cards/card/' . $action, 'id_card' => $this->id_card, 'id_mode' => $id_mode]);
    }
}
