<?php

namespace app\tests\functional;

require_once 'CardBase.php';

use app\models\Card;

class CardCest extends CardBase
{
    /**
     *
     */
	public function clear(\FunctionalTester $I)
	{
        parent::clear($I);

        $I->dontSeeRecord(Card::className());
	}


    /**
     * @depends clear
     */
	public function create(\FunctionalTester $I)
	{
        parent::createCard($I);
	}

    /**
     * @depends create
     */
    public function view(\FunctionalTester $I)
    {
        $this->openCard($I);

        $I->see('New card', 'h1');
    }


    /**
     * @depends create
     */
    public function update(\FunctionalTester $I)
    {
        $this->openCard($I);
        $I->click('Настройки техкарты');


    	$I->fillField('#card-name', 'New updated card');
        $I->click('Сохранить', '#card-form');

        $I->seeRecord(Card::className(), ['name' => 'New updated card']);
        $I->seeInCurrentUrl('/cards/' . $this->id_card);
    }

    /**
     * @depends create
     */
    public function index(\FunctionalTester $I)
    {
    	$I->amOnPage(['cards/index', 'id_mode' => 'my']);

    	$I->see('New updated card');
    }

    /**
     * @depends create
     */
    public function delete(\FunctionalTester $I)
    {
        $this->openCard($I, 'view', 'my');
        $I->click('Удалить техкарту');

        $I->dontSeeRecord(Card::className());
    }

}
