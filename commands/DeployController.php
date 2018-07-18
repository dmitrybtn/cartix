<?php

namespace app\commands;

use Yii;
use yii\console\ExitCode;
use yii\helpers\Console;
use yii\helpers\FileHelper;

/**
 * Деплой кода и данных на сервер
 *
 */
class DeployController extends \yii\console\Controller
{
	const FG_STD = Console::FG_GREEN;

	public $username;
	public $host;
	public $path;
	public $exclude = [
		'.git/',
		'.DS_Store',
		'/config/db.php',
		'/dmitrybtn/docs/',
		'/runtime/*',
		'/vendor/*',
		'/yii',
		'/web/assets/*',
		'/web/index.php',		
	];

    /**
     * @var bool Обратный порядок синхронизации (с сервера на локальную машину)
     */
	public $reverse = false;

    /**
     * @var bool Ускоренная синхронизация (без подтверждения)
     */
	public $force = false;


    /**
     * @inheritdoc
     */
	public function options($actionId)
	{
		return ['reverse', 'force', 'help'];
	}

	protected $sql;


    /**
     * @inheritdoc
     */
    public function optionAliases()
    {
        return array_merge(parent::optionAliases(), [
        	'r' => 'reverse',
        	'f' => 'force',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
		if (!is_dir($strPath = Yii::getAlias('@runtime/deploy')))
			FileHelper::createDirectory($strPath, 0777);

		$this->sql = Yii::getAlias('@runtime/deploy') . '/dump.sql';    	
    }



    /**
     * Деплой кода
     */
	public function actionIndex()
	{
		if (!YII_ENV_DEV)
			return $this->error('Опция доступна только в режиме разработки!');

		if ($this->force) {

			// Обратная ускоренная запрещена
			if ($this->reverse) {
				$this->stdout("Ускоренная обратная передача запрещена!\n", Console::FG_RED);
				return ExitCode::UNSPECIFIED_ERROR;									
			}

			// Выполнить передачу
			if (!$this->deployCode(true)) {
				$this->stdout("Ошибка при передаче!\n", Console::FG_RED);
				return ExitCode::UNSPECIFIED_ERROR;					
			}


		} else {

			$this->stdout("Сравниваю каталоги...\n", self::FG_STD);
			
			if ($this->deployCode(false)) {

				if ($this->reverse)
					$this->stdout("Внимание! Передача в обратном направлении. Настоятельно рекомендуется сделать коммит.\n\n", Console::FG_BLUE);

				Console::beginAnsiFormat([self::FG_STD]);
				$proceed = Console::confirm('Продолжить синхронизацию?');
				Console::endAnsiFormat();

				if ($proceed) {
					$this->stdout("Выполняю синхронизацию... ", self::FG_STD);

					if ($this->deployCode(true)) {
						$this->stdout("OK\n", self::FG_STD);
						return ExitCode::OK;	
					} else {
						$this->stdout("ОШИБКА\n", Console::FG_RED);
						return ExitCode::UNSPECIFIED_ERROR;					
					}

				} else {
					$this->stdout("Пока-пока\n", self::FG_STD);
					return ExitCode::OK;	
				} 
			} else {
				$this->stdout("ОШИБКА\n", Console::FG_RED);
				return ExitCode::UNSPECIFIED_ERROR;									
			}
		}		
	}

    /**
     * Деплой данных
     */
	public function actionDb($scenario = 'deploy')
	{
		switch ($scenario) {
			case 'deploy':
				
				if (!YII_ENV_DEV)
					return $this->error('Опция доступна только в режиме разработки!');

				Console::beginAnsiFormat([self::FG_STD]);
				$proceed = Console::confirm('База будет ' . ($this->reverse ? 'ЗАГРУЖЕНА' : 'ПЕРЕДАНА') . '. Продолжить?');
				Console::endAnsiFormat();

				if (!$proceed) {
					$this->stdout("Пока-пока\n", self::FG_STD);
					return ExitCode::OK;	
				}

				if ($this->reverse) {

					$this->stdout("Создаю дамп... \n", self::FG_STD);
					if ($this->ssh('deploy/db dump')) {

						$this->stdout("Передаю дамп... \n", self::FG_STD);
						if ($this->deployData()) {
							
							$this->stdout("Восстанавливаю дамп... \n", self::FG_STD);

							if ($this->retreive()) return ExitCode::OK;
							else return $this->error();

						} else return $this->error();
					} else return $this->error();
			
				} else {
					$this->stdout("Создаю дамп... \n", self::FG_STD);
					if ($this->dump()) {

						$this->stdout("Передаю дамп... \n", self::FG_STD);
						if ($this->deployData()) {
							
							$this->stdout("Восстанавливаю дамп... \n", self::FG_STD);

							if ($this->ssh('deploy/db retreive')) return ExitCode::OK;
							else return $this->error();

						} else return $this->error();
					} else return $this->error();
				}


				

			case 'dump':

				if ($this->dump()) return ExitCode::OK;
				else return ExitCode::UNSPECIFIED_ERROR;

			case 'retreive':

				if ($this->retreive()) return ExitCode::OK;
				else return ExitCode::UNSPECIFIED_ERROR;

			default:
				$this->stdout("Неизвестный сценарий\n", Console::FG_RED);
				return ExitCode::UNSPECIFIED_ERROR;
		}
	}

    /**
     * Завершение команды с ошибкой
     */
	protected function error($message = 'Ошибка')
	{
		$this->stderr("$message\n", Console::FG_RED);
		return ExitCode::UNSPECIFIED_ERROR;												
	}

    /**
     * Выполнение команды на удаленном сервере
     */
	protected function ssh($command)
	{
		exec("ssh $this->username@$this->host \"$this->path/yii $command\"", $o, $r);

		return $r == ExitCode::OK;
	}

    /**
     * Создание временной копии базы данных
     */
	protected function dump()
	{
		exec('mysqldump' .  
			' -u' . Yii::$app->db->username . 
			' -p' . Yii::$app->db->password . 
			' ' . Yii::$app->db->createCommand("SELECT DATABASE()")->queryScalar() . 
			' >> ' . $this->sql,
			$o, $r);

		return $r == ExitCode::OK;		
	}

    /**
     * Восстановление временной копии базы данных
     */
	protected function retreive()
	{
		if (!is_file($this->sql)) {
			$this->stdout("Дамп не найден\n", Console::FG_RED);
			return ExitCode::UNSPECIFIED_ERROR;															
		}

		exec('mysql' .  
			' -u' . Yii::$app->db->username . 
			' -p' . Yii::$app->db->password . 
			' ' . Yii::$app->db->createCommand("SELECT DATABASE()")->queryScalar() . 
			' < ' . $this->sql . ' 2>&1',
			$o, $r);

		return $r == ExitCode::OK;		
	}


    /**
     * Деплой данных через scp
     */
	protected function deployData()
	{
		$order = "$this->username@$this->host:$this->path/runtime/deploy/dump.sql";
		$order = $this->reverse ? $order . " $this->sql" : "$this->sql " . $order;
		
		exec("scp $order", $o, $r);

		return $r == ExitCode::OK;
	}


    /**
     * Деплой кода через rsync
     */
	protected function deployCode($modeReal)
	{
		$exclude = ' --exclude ' . implode(' --exclude ', $this->exclude);

		$order = "$this->username@$this->host:$this->path";
		$order = $this->reverse ? $order . ' ./' : './ ' . $order;

		$mode = $modeReal ? '' : '--dry-run';

		exec("rsync -az --force --delete --progress $mode $exclude -e ssh $order", $o, $r);

		if (!$modeReal) {
			echo "\n";			
			for ($i = 1; $o[$i] != ''; $i++) 
				echo $o[$i] . "\n";
			echo "\n";			
		}

		return $r == ExitCode::OK;
	}

}