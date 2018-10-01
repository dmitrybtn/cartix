<?php

namespace app\tests\acceptance;

use app\modules\cards\models\{Card, CardTransfer, CardObject};
use app\tests\fixtures\UsersFixture;

use yii\helpers\Url;

class TestCest
{

    public function _before(\AcceptanceTester $I)
    {
        $I->haveFixtures([
            'users' => UsersFixture::className(),
        ]);

        $I->amOnPage(Url::to(['/users/login/login']));        
        
        $I->fillField('UserLogin[email]', 'root@root.ru');
        $I->fillField('UserLogin[password]', '123');
        $I->click('Войти');
        $I->wait(0.5);        
    }

    public function CardPlan(\AcceptanceTester $I)
    {
        Card::deleteAll();

        $I->amOnPage(Url::to(['/cards/list/create']));  

        // Создание техкарты
        $I->fillField('Card[name]', 'New card');
        $I->click('Сохранить');
        $I->wait(0.5);
        $I->seeRecord(Card::className(), ['name' => 'New card']);

        // Создание остановки
        $I->click('Добавить остановку');
        $I->fillField('CardTransfer[name]', 'New transfer');
        $I->click('Сохранить');
        $I->wait(0.5);
        $I->seeRecord(CardTransfer::className(), ['name' => 'New transfer']);

        // Создание объекта
        $I->click('Добавить объект');
        $I->fillField('CardObject[name]', 'New object');
        $I->click('Сохранить', '.cards_plan_object--modal');
        $I->wait(0.5);
        $I->seeRecord(CardObject::className(), ['name' => 'New object']);

        // Редактирование остановки
        $I->click('New transfer', '.cards_plan_transfers');
        $I->fillField('CardTransfer[name]', 'New 2 transfer');
        $I->click('Сохранить');
        $I->wait(0.5);
        $I->seeRecord(CardTransfer::className(), ['name' => 'New 2 transfer']);


        // Редактирование объекта
        $I->click('New object', '.cards_plan_transfers');
        $I->fillField('CardObject[name]', 'New 2 object');
        $I->click('Сохранить', '.cards_plan_object--modal');
        $I->wait(0.5);
        $I->seeRecord(CardObject::className(), ['name' => 'New 2 object']);


        // Удаление объекта
        $I->click('New 2 object', '.cards_plan_transfers');
        $I->click('Удалить объект', '.cards_plan_object--modal');
        $I->acceptPopup();
        $I->wait(0.5);
        $I->dontSeeRecord(CardObject::className(), ['name' => 'New 2 object']);

        // Удаление остановки
        $I->click('New 2 transfer', '.cards_plan_transfers');
        $I->click('Удалить остановку', '.cards_plan_transfer--modal');
        $I->acceptPopup();
        $I->wait(0.5);
        $I->dontSeeRecord(CardTransfer::className(), ['name' => 'New 2 transfer']);


    }

    

}
