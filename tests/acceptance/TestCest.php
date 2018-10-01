<?php

namespace app\tests\acceptance;

use app\modules\cards\models\{Card, CardTransfer, CardObject};
use app\tests\fixtures\UsersFixture;

use yii\helpers\Url;

class TestCest
{

    public function _before(\FunctionalTester $I)
    {
        $I->haveFixtures([
            'users' => UsersFixture::className(),
        ]);
    }

    public function login(\AcceptanceTester $I)
    {
        $I->amOnPage(Url::to(['/users/login/login']));        
        
        $I->fillField('UserLogin[email]', 'root@root.ru');
        $I->fillField('UserLogin[password]', '123');
        $I->click('Войти');

        $I->waitForElement('h1', 1);

        $I->amOnPage(Url::to(['/cards/list/index', 'id_mode' => 'my']));  
        

    }

    public function createCard(\AcceptanceTester $I)
    {
              
    
        $I->wait(3);

        $I->see('Мои техкарты');

    }

}
