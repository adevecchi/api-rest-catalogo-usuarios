<?php

namespace App\Controllers\Api;

use \App\Controllers\Controller;

class CreateMysqlDBController extends Controller
{
	private $config;
	private $baseDir;


	public function __construct()
	{
		parent::__construct();
		
		$dir = dirname(dirname(__FILE__));
		$this->baseDir = dirname(dirname($dir));
	}

	
	public function create()
	{
		try {
			$this->loadConfig();

			$dbh = new \PDO('mysql:host='.$this->config['db_host'].';charset='.$this->config['db_utf8'], $this->config['db_user'], $this->config['db_pass']);

			$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

			$dbh->exec(file_get_contents($this->baseDir . '/config/mysql_script/dvq_mob.sql'));
		} catch (\PDOException $e) {
			throw new \Exception('PDO Connection: '.$e->getMessage());
		}

		try {
			$dbh->beginTransaction();

			$this->insertUsers($dbh, json_decode(file_get_contents('http://jsonplaceholder.typicode.com/users')));
			$this->insertPosts($dbh, json_decode(file_get_contents('http://jsonplaceholder.typicode.com/posts')));

			$dbh->commit();

			$this->app->render('/response/json.php', [
				'app' => $this->app,
				'code' => 200,
				'result' => ['code' => 200, 'status' => 'OK']
			]);
		} catch (\PDOException $e) {
			$dbh->rollback();

			$this->app->render('/response/json.php', [
				'app' => $this->app,
				'code' => 500,
				'result' => ['code' => 500, 'status' => 'Internal Server Error']
			]);
		}
	}

	
	private function loadConfig()
	{
		$file = $this->baseDir . '/config/mysql.ini';

		if (file_exists($file)) {
			$this->config = parse_ini_file($file);
		} else {
			throw new \Exception('Config database file not found');
		}
	}

	
	private function insertUsers($dbh, Array $users)
	{
		try {
			$query = "INSERT INTO `users` (
							`name`,
							`username`,
							`email`,
							`addr_street`,
							`addr_suite`,
							`addr_city`,
							`addr_zipcode`,
							`addr_geo_lat`,
							`addr_geo_lng`,
							`phone`,
							`website`,
							`co_name`,
							`co_catchPhrase`,
							`co_bs`
						)
					  VALUES (
							:name,
							:username,
							:email,
							:addr_street,
							:addr_suite,
							:addr_city,
							:addr_zipcode,
							:addr_geo_lat,
							:addr_geo_lng,
							:phone,
							:website,
							:co_name,
							:co_catchPhrase,
							:co_bs
						)";

			$pstmt = $dbh->prepare($query);

			foreach ($users as $user) {
				$pstmt->bindValue(':name', $user->name);
				$pstmt->bindValue(':username', $user->username);
				$pstmt->bindValue(':email', $user->email);
				$pstmt->bindValue(':addr_street', $user->address->street);
				$pstmt->bindValue(':addr_suite', $user->address->suite);
				$pstmt->bindValue(':addr_city', $user->address->city);
				$pstmt->bindValue(':addr_zipcode', $user->address->zipcode);
				$pstmt->bindValue(':addr_geo_lat', $user->address->geo->lat);
				$pstmt->bindValue(':addr_geo_lng', $user->address->geo->lng);
				$pstmt->bindValue(':phone', $user->phone);
				$pstmt->bindValue(':website', $user->website);
				$pstmt->bindValue(':co_name', $user->company->name);
				$pstmt->bindValue(':co_catchPhrase', $user->company->catchPhrase);
				$pstmt->bindValue(':co_bs', $user->company->bs);

				$pstmt->execute();
			}
			$pstmt->closeCursor();
		} catch(\PDOExecption $e) {
			throw new \Exception('Insert Users: '.$e->getMessage());	
		}
	}

	
	private function insertPosts($dbh, Array $posts)
	{
		try {
			$query = "INSERT INTO `posts` (
							`userId`,
							`title`,
							`body`
						)
					  VALUES (
					  		:userId,
							:title,
							:body
						)";

			$pstmt = $dbh->prepare($query);

			foreach ($posts as $post) {
				$pstmt->bindValue(':userId', $post->userId);
				$pstmt->bindValue(':title', $post->title);
				$pstmt->bindValue(':body', $post->body);
				
				$pstmt->execute();
			}
			$pstmt->closeCursor();
		} catch(\PDOExecption $e) {
			throw new \Exception('Insert Posts: '.$e->getMessage());	
		}
	}
}