<?php

namespace app\tests\functional;

class IndexCest
{



    public function Index(\FunctionalTester $I)
    {
        $I->seeInDatabase('users', ['name' => 'Davert', 'email' => 'davert@mail.com']);
    }


}
