<?php

namespace app\tests\functional;

require_once 'CardBase.php';

use app\models\{Card, CardTransfer};

class CardTransferCest extends CardBase
{
    /**
     *
     */
	public function clear(\FunctionalTester $I)
	{
        parent::clear($I);

        $I->dontSeeRecord(CardTransfer::className());

	}

    /**
     * @depends clear
     */
    public function create(\FunctionalTester $I)
    {
        parent::createCard($I);
        parent::createTransfer($I);
    }


    /**
     *  @depends create
     */
    public function viewInPlan(\FunctionalTester $I)
    {
        $this->openCard($I);

        $I->see('New transfer', '.card_plan--transfer');
        $I->see('New transfer', '.card_plan-mobile--transfer');
    }

    /**
     *  @depends create
     */
    public function viewInText(\FunctionalTester $I)
    {
        $this->openCard($I, 'text');

        $I->see('New transfer', '.card_text--header_transfer');
    }

    /**
     *  @depends create
     */
    public function update(\FunctionalTester $I)
    {
        $this->openCard($I);
       
        $I->click('a.update', "tr[data-transfer-key=$this->id_transfer]");

        $I->fillField('#cardtransfer-name', 'New updated transfer');

        $I->click('Сохранить', '#card-transfer-form');

        $I->seeRecord(CardTransfer::className(), ['name' => 'New updated transfer']);   
    }


    /**
     *  @depends create
     */
    public function delete(\FunctionalTester $I)
    {
        $this->openCard($I);
        
        $I->click('a.delete', "tr[data-transfer-key=$this->id_transfer]");
        
        $I->dontSeeRecord(CardTransfer::className());   
    }

}
