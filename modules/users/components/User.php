<?php

namespace app\modules\users\components;

use Yii;

//*****************************************************************************
class User extends \dmitrybtn\cp\users\components\User
//*****************************************************************************
{
	public $identityClass = 'app\modules\users\models\User';
}