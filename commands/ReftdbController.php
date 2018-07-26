<?php

namespace app\commands;

use Yii;
use yii\console\ExitCode;
use yii\helpers\Console;

/**
 * Обновление структуры тестовой базы данных
 */
class ReftdbController extends \yii\console\Controller
{
	const FG_STD = Console::FG_GREEN;

	public $defaultAction = 'run';

    /**
     * Переносит структуру рабочей базы в тестовую
     */
	public function actionRun()
	{
		$strFile = Yii::getAlias('@app/tests/_data/dump.sql');

		$sttDb1 = require Yii::getAlias('@app/config/db.php');
		$sttDb2 = require Yii::getAlias('@app/config/db_test.php');

		$this->stdout("Создаю дамп...\n", self::FG_STD);

		exec('mysqldump' .  
			' --no-data ' .
			' -u' . $sttDb1['username'] . 
			' -p' . $sttDb1['password'] . 
			' ' . $this->getDsnAttribute('dbname', $sttDb1['dsn']) . 
			' > ' . $strFile,
			$o, $r);

		if ($r == ExitCode::OK) {

			$this->stdout("Применяю дамп...\n", self::FG_STD);

			exec('mysql' .  
				' -u' . $sttDb2['username'] . 
				' -p' . $sttDb2['password'] . 
				' ' . $this->getDsnAttribute('dbname', $sttDb2['dsn']) . 
				' < ' . $strFile . ' 2>&1',
				$o, $r);

		} else $this->stdout("Ошибка!\n", self::FG_STD);

		return $r;
	}


    /**
     * Возвращает атрибут из строки DSN
     */
	private function getDsnAttribute($name, $dsn)
    {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }

}