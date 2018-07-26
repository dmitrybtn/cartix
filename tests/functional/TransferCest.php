<?php

namespace app\tests\functional;

use app\models\{Card, CardTransfer};

use yii\helpers\Url;

class TransferCest
{
	public $id_card;
    public $id_transfer;


    /**
     *
     */
	public function prepare(\FunctionalTester $I)
	{
        Card::deleteAll();

        $modCard = new Card;
        $modCard->name = 'Transfers card';
        $modCard->save();

        $this->id_card = $modCard->id;
	}

    /**
     *
     */
    public function create(\FunctionalTester $I)
    {
    	$I->amOnPage(['card/view', 'id' => $this->id_card]);
    	$I->click('Добавить остановку');

    	$I->fillField('#cardtransfer-name', 'New transfer');
        $I->click('Сохранить', '#card-transfer-form');

        $I->see('New transfer', '.card_plan');
        $I->see('New transfer', '.well_list-1');

        $this->id_transfer = $I->grabRecord(CardTransfer::className(), ['name' => 'New transfer'])->id;
    }


    /**
     *
     */
    public function update(\FunctionalTester $I)
    {
        $I->amOnPage(['card/view', 'id' => $this->id_card]);
        
        $I->click('a.update', "tr[data-transfer-key=$this->id_transfer]");

        $I->fillField('#cardtransfer-name', 'New transfer 2');
        $I->click('Сохранить', '#card-transfer-form');

        $I->seeRecord(CardTransfer::className(), ['name' => 'New transfer 2']);   
    }


    /**
     *
     */
    public function delete(\FunctionalTester $I)
    {
        $I->amOnPage(['card/view', 'id' => $this->id_card]);
        
        $I->click('a.delete', "tr[data-transfer-key=$this->id_transfer]");
        
        $I->dontSeeRecord(CardTransfer::className(), ['name' => 'New transfer 2']);   
    }

}
