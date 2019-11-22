<?php

namespace app\controllers;

use \app\models\Users as UsersModel;

class Users extends Controller
{
	/*
	 *
	 */
	public function getUsers()
	{
		$result = (new UsersModel())->getUsers();

		if ($result !== false) {
			$this->app->render('default.php', ['data' => $result], 200);
		} else {
			$this->app->render('default.php', ['data' => ['status' => 'Not Found']], 404);
		}
	}

	/*
	 *
	 */
	public function getUser($id) 
	{
		$result = (new UsersModel())->getUser($id);

		if ($result !== false) {
			$this->app->render('default.php', ['data' => $result], 200);
		} else {
			$this->app->render('default.php', ['data' => ['status' => 'Not Found']], 404);
		}
	}

	/*
	 *
	 */
	public function getPosts($id) 
	{
		$result = (new UsersModel())->getPosts($id);

		if ($result !== false) {
			$this->app->render('default.php', ['data' => $result], 200);
		} else {
			$this->app->render('default.php', ['data' => ['status' => 'Not Found']], 404);
		}
	}

	/*
	 *
	 */
	public function all()
	{
		$json_data = (new UsersModel())->all();

		$this->app->render('default.php', ['data' => $json_data], 200);
	}

	/*
	 *
	 */
	public function allPosts($id)
	{
		$json_data = (new UsersModel())->allPosts($id);

		$this->app->render('default.php', ['data' => $json_data], 200);
	}

	/*
	 *
	 */
	public function add()
	{
		$data = json_decode($this->app->request->getBody());

		$result = (new UsersModel())->add($data);
		
		if ($result) {
			$this->app->render('default.php', ['data' => ['status' => 'Ok']], 201);
		} else {
			$this->app->render('default.php', ['data' => ['status' => 'Not Found']], 404);
		}
	}

	/*
	 *
	 */
	public function update($id)
	{
		$data = json_decode($this->app->request->getBody());

		$result = (new UsersModel())->update($id, $data);

		if ($result) {
			$this->app->render('default.php', ['data' => ['status' => 'Ok']], 200);
		} else {
			$this->app->render('default.php', ['data' => ['status' => 'Not Found']], 404);
		}
	}

	/*
	 *
	 */
	public function delete($id)
	{
		$result = (new UsersModel())->delete($id);

		if ($result) {
			$this->app->render('default.php', ['data' => ['status' => 'Ok']], 204);
		} else {
			$this->app->render('default.php', ['data' => ['status' => 'Not Found']], 404);
		}
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
}
