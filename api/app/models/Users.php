<?php

namespace app\models;

use \app\helpers\DB;

class Users
{
	private $dbh;

	/*
	 *
	 */
	public function __construct()
	{
		$this->dbh = DB::create()->getConnection();
	}

	/*
	 *
	 */
	public function getUsers()
	{
		$pstmt = $this->dbh->prepare('SELECT * FROM users');
		$pstmt->execute();

		if ($pstmt->rowCount()) {
			$result = $this->formatUser($pstmt->fetchAll(\PDO::FETCH_ASSOC));
		} else {
			$result = false;
		}

		$pstmt->closeCursor();

		return $result;
	}

	/*
	 *
	 */
	public function getUser($id) 
	{
		$pstmt = $this->dbh->prepare('SELECT * FROM users WHERE id = :id');
		$pstmt->bindValue(':id', $id);
		$pstmt->execute();

		if ($pstmt->rowCount()) {
			$result = $this->formatUser([0 => $pstmt->fetch(\PDO::FETCH_ASSOC)]);
		} else {
			$result = false;
		}

		$pstmt->closeCursor();

		return $result;
	}

	/*
	 *
	 */
	public function getPosts($id) 
	{
		$pstmt = $this->dbh->prepare('SELECT * FROM posts WHERE userId = :userId');
		$pstmt->bindValue(':userId', $id);
		$pstmt->execute();

		if ($pstmt->rowCount()) {
			$result = $pstmt->fetchAll(\PDO::FETCH_ASSOC);
		} else {
			$result = false;
		}

		$pstmt->closeCursor();

		return $result;
	}

	/*
	 *
	 */
	private function formatUser(Array $users)
	{
		$count = 0;

		$aux = [];
		$formated = [];

		$level1   = ['id', 'name', 'username', 'email', 'phone', 'website'];
		$level2_1 = ['addr_street', 'addr_suite', 'addr_city', 'addr_zipcode'];
		$level2_2 = ['addr_geo_lat', 'addr_geo_lng'];
		$lavel3   = ['co_name', 'co_catchPhrase', 'co_bs']; 

		foreach ($users as $user) {
			foreach ($user as $key => $value) {
				if (in_array($key, $level1)) {
					$aux[$key] = $value;
				} else if (in_array($key, $level2_1)) {
					$aux['address'][substr($key, 5)] = $value;
				} else if (in_array($key, $level2_2)) {
					$aux['address']['geo'][substr($key, 9)] = $value;
				} else if (in_array($key, $lavel3)) {
					$aux['company'][substr($key, 3)] = $value;

					$count++;
					if ($count == 3) {
						array_push($formated, $aux);
						$aux = [];
						$count = 0;
					}
				}
			}
		}

		return $formated;
	}

	/*
	 *
	 */
	public function all()
	{
		$pstmt = $this->dbh->prepare('SELECT * FROM users');
		$pstmt->execute();

		$totalData = $pstmt->rowCount();
		$totalFiltered = $totalData;

		$pstmt = $this->dbh->prepare('SELECT * FROM users ORDER BY id LIMIT :start, :length');
		$pstmt->bindValue(':start', $_POST['start'], \PDO::PARAM_INT);
		$pstmt->bindValue(':length', $_POST['length'], \PDO::PARAM_INT);
		$pstmt->execute();

		$result = $pstmt->fetchAll(\PDO::FETCH_ASSOC);

		$pstmt->closeCursor();

		$data = [];
		foreach ($result as $user) {
			$data[] = [
				'id'       => $user['id'],
				'name'     => $user['name'],
				'username' => $user['username'],
				'email'    => $user['email'],
				'phone'    => $user['phone'],
				'website'  => $user['website'],
				'actions'  => '<a class="btn btn-warning btn-xs btn-edit" href="javascript:;" data-id="'.$user['id'].'">Edit</a>
									<a class="btn btn-danger btn-xs btn-delete" href="javascript:;" data-id="'.$user['id'].'">Delete</a>
									<a class="btn btn-info btn-xs btn-details" href="javascript:;" data-id="'.$user['id'].'">Details</a>'
			];
		}

		$json_data = [
            "draw"            => intval($_POST['draw']),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ];

        return $json_data;
	}

	/*
	 *
	 */
	public function allPosts($id)
	{
		$pstmt = $this->dbh->prepare('SELECT * FROM posts WHERE userId = :userId');
		$pstmt->bindValue(':userId', $id, \PDO::PARAM_INT);
		$pstmt->execute();

		$totalData = $pstmt->rowCount();
		$totalFiltered = $totalData;

		$pstmt = $this->dbh->prepare('SELECT * FROM posts WHERE userId = :userId ORDER BY id LIMIT :start, :length');
		$pstmt->bindValue(':userId', $id, \PDO::PARAM_INT);
		$pstmt->bindValue(':start', $_POST['start'], \PDO::PARAM_INT);
		$pstmt->bindValue(':length', $_POST['length'], \PDO::PARAM_INT);
		$pstmt->execute();

		$result = $pstmt->fetchAll(\PDO::FETCH_ASSOC);

		$pstmt->closeCursor();

		$data = [];
		foreach ($result as $user) {
			$data[] = [
				'id'    => $user['id'],
				'title' => $user['title'],
				'body'  => $user['body']
			];
		}

		$json_data = [
            "draw"            => intval($_POST['draw']),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ];

        return $json_data;
	}

	/*
	 *
	 */
	public function add($data)
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

			$pstmt = $this->dbh->prepare($query);
			$pstmt->bindValue(':name', $data->name);
			$pstmt->bindValue(':username', $data->username);
			$pstmt->bindValue(':email', $data->email);
			$pstmt->bindValue(':addr_street', $data->addr_street);
			$pstmt->bindValue(':addr_suite', $data->addr_suite);
			$pstmt->bindValue(':addr_city', $data->addr_city);
			$pstmt->bindValue(':addr_zipcode', $data->addr_zipcode);
			$pstmt->bindValue(':addr_geo_lat', $data->addr_geo_lat);
			$pstmt->bindValue(':addr_geo_lng', $data->addr_geo_lng);
			$pstmt->bindValue(':phone', $data->phone);
			$pstmt->bindValue(':website', $data->website);
			$pstmt->bindValue(':co_name', $data->co_name);
			$pstmt->bindValue(':co_catchPhrase', $data->co_catchPhrase);
			$pstmt->bindValue(':co_bs', $data->co_bs);
			$pstmt->execute();

			return true;
		} catch(\PDOExecption $e) {
			return false;
		}
	}

	/*
	 *
	 */
	public function update($id, $data)
	{
		try {
			$query = "UPDATE `users`
						 SET
							`name` = :name,
							`username` = :username,
							`email` = :email,
							`addr_street` = :addr_street,
							`addr_suite` = :addr_suite,
							`addr_city` = :addr_city,
							`addr_zipcode` = :addr_zipcode,
							`addr_geo_lat` = :addr_geo_lat,
							`addr_geo_lng` = :addr_geo_lng,
							`phone` = :phone,
							`website` = :website,
							`co_name` = :co_name,
							`co_catchPhrase` = :co_catchPhrase,
							`co_bs` = :co_bs
						 WHERE 
						 	`id` = :id";

			$pstmt = $this->dbh->prepare($query);
			$pstmt->bindValue(':name', $data->name);
			$pstmt->bindValue(':username', $data->username);
			$pstmt->bindValue(':email', $data->email);
			$pstmt->bindValue(':addr_street', $data->addr_street);
			$pstmt->bindValue(':addr_suite', $data->addr_suite);
			$pstmt->bindValue(':addr_city', $data->addr_city);
			$pstmt->bindValue(':addr_zipcode', $data->addr_zipcode);
			$pstmt->bindValue(':addr_geo_lat', $data->addr_geo_lat);
			$pstmt->bindValue(':addr_geo_lng', $data->addr_geo_lng);
			$pstmt->bindValue(':phone', $data->phone);
			$pstmt->bindValue(':website', $data->website);
			$pstmt->bindValue(':co_name', $data->co_name);
			$pstmt->bindValue(':co_catchPhrase', $data->co_catchPhrase);
			$pstmt->bindValue(':co_bs', $data->co_bs);
			$pstmt->bindValue(':id', $id);
			$pstmt->execute();

			return true;
		} catch(\PDOExecption $e) {
			return false;
		}
	}

	/*
	 *
	 */
	public function delete($id)
	{
		try {
			$query = "DELETE FROM `users` WHERE `id` = :id";

			$pstmt = $this->dbh->prepare($query);
			$pstmt->bindValue(':id', $id);
			$pstmt->execute();

			return true;
		} catch(\PDOExecption $e) {
			return false;
		}
	}
}