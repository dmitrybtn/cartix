<?php

namespace app\tests\functional;

require_once 'CardBase.php';

use app\models\{CardSubscribe};
use app\tests\fixtures\UsersFixture;


class CardSubscribeCest extends CardBase
{
 
    public function _before(\FunctionalTester $I)
    {
        $I->haveFixtures([
            'users' => UsersFixture::className(),
        ]);

        // $I->amLoggedInAs($I->grabFixture('users', 'root')->id);
    }


    /**
     *
     */
	public function clear(\FunctionalTester $I)
	{
        parent::clear($I);

        $I->dontSeeRecord(CardSubscribe::className());
	}

    /**
     * @depends clear
     */
    public function create(\FunctionalTester $I)
    {
        $I->amLoggedInAs($I->grabFixture('users', 'root')->id);

        parent::createCard($I);
    }


    /**
     * @depends create
     */
    public function ownerCantSubscribe(\FunctionalTester $I)
    {
        $I->amLoggedInAs($I->grabFixture('users', 'root')->id);

        $this->openCard($I);

        $I->dontSee('Подписаться', '.deskmenu');
    }


    /**
     * @depends create
     */
    public function guestCantSubscribe(\FunctionalTester $I)
    {
        // GUEST

        $this->openCard($I);

        $I->dontSee('Подписаться', '.deskmenu');
    }


    /**
     * @depends create
     */
    public function listIsEmpty(\FunctionalTester $I)
    {
        $I->amLoggedInAs($id_user = $I->grabFixture('users', 'user')->id);

        $I->amOnPage(['card/list/index', 'id_mode' => 'subscr']);

        $I->see('Ничего не найдено', '#card_index--grid');
    }


    /**
     * @depends create
     */
    public function subscribe(\FunctionalTester $I)
    {
        $I->amLoggedInAs($id_user = $I->grabFixture('users', 'user')->id);

        $this->openCard($I);

        $I->click('Подписаться', '.deskmenu');
        
        $I->seeRecord(CardSubscribe::className(), ['id_user' => $id_user]);
    }

    /**
     * @depends create
     */
    public function listContainsCard(\FunctionalTester $I)
    {
        $I->amLoggedInAs($id_user = $I->grabFixture('users', 'user')->id);

        $I->amOnPage(['card/list/index', 'id_mode' => 'subscr']);

        $I->see('New card', '#card_index--grid');
    }

    /**
     * @depends create
     */
    public function unsubscribe(\FunctionalTester $I)
    {
        $I->amLoggedInAs($id_user = $I->grabFixture('users', 'user')->id);

        $this->openCard($I);

        $I->click('Отписаться', '.deskmenu');
        
        $I->dontSeeRecord(CardSubscribe::className(), ['id_user' => $id_user]);
    }

}
