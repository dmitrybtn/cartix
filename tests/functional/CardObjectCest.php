<?php

namespace app\tests\functional;

require_once 'CardBase.php';

use app\models\CardObject;

class CardObjectCest extends CardBase
{
    /**
     *
     */
	public function clear(\FunctionalTester $I)
	{
        parent::clear($I);

        $I->dontSeeRecord(CardObject::className());
	}

    /**
     * @depends clear
     */
    public function create(\FunctionalTester $I)
    {
        parent::createCard($I);
        parent::createTransfer($I);
        parent::createObject($I);
    }





    /**
     *  @depends create
     */
    public function viewInPlan(\FunctionalTester $I)
    {
        $this->openCard($I, 'view');

        $I->see('New object', '.card_plan--object');
        $I->see('New object', '.card_plan-mobile--object');
    }

    /**
     *  @depends create
     */
    public function viewInText(\FunctionalTester $I)
    {
        $this->openCard($I, 'view-text');

        $I->see('New object', '.card_text--header_object');
    }

    /**
     *  @depends create
     */
    public function update(\FunctionalTester $I)
    {
        $this->openCard($I);
        
        $I->click('a.update', "tr[data-object-key=$this->id_object]");

        $I->fillField('#cardobject-name', 'New updated object');
        $I->click('Сохранить', '#card-object-form');

        $I->seeRecord(CardObject::className(), ['name' => 'New updated object']);   
    }


    /**
     *  @depends create
     */
    public function delete(\FunctionalTester $I)
    {
        $this->openCard($I);
        
        $I->click('a.delete', "tr[data-object-key=$this->id_object]");
        
        $I->dontSeeRecord(CardObject::className());   
    }

}
