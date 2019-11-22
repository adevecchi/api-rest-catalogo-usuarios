<?php

namespace app\helpers;

final class DB 
{
	private $config;
	private $connection;

	private static $instance = null;

	/*
	 *
	 */
	private function __construct() 
	{
		try {
			$this->loadConfig();

			$this->connection = new \PDO('mysql:host='.$this->config['db_host'].';dbname='.$this->config['db_name'].';charset='.$this->config['db_utf8'], $this->config['db_user'], $this->config['db_pass']);

			$this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		} catch (\PDOException $e) {
			throw new \Exception('Error: ' . $e->getMessage());
		} catch (Exception $e) {
			throw new \Exception('Error: ' . $e->getMessage());
		}
	}

	private function __clone() {}
	private function __wakeup() {}

	/*
	 *
	 */
	private function loadConfig()
	{
		$file = URL_BASE . '/app/config/mysql.ini';

		if (file_exists($file)) {
			$this->config = parse_ini_file($file);
		} else {
			throw new \Exception('Error: Config database file not found');
		}
	}

	/*
	 *
	 */
	public function getConnection()
	{
		return $this->connection;
	}

	/*
	 *
	 */
	public static function create()
	{
		if (self::$instance === null) {
			self::$instance = new static();
		}

		return self::$instance;
	}	
}