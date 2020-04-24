<?php

namespace App\Controllers\Api;

use \App\Models\Users;
use \App\Controllers\Controller;

class UsersController extends Controller
{
	public function getUsers()
	{
		$result = (new Users())->getUsers();

		if ($result !== false) {
			$res = [
				'app' => $this->app,
				'code' => 200,
				'result' => $result
			];
		} else {
			$res = [
				'app' => $this->app,
				'code' => 404,
				'result' => ['code' => 404, 'status' => 'Not Found']
			];
		}

		$this->app->render('/response/json.php', $res);
	}
	

	public function getUser($id) 
	{
		$result = (new Users())->getUser($id);

		if ($result !== false) {
			$res = [
                'app' => $this->app,
                'code' => 200,
                'result' => $result[0]
            ];
		} else {
			$res = [
                'app' => $this->app,
                'code' => 404,
                'result' => ['code' => 404, 'status' => 'Not Found']
            ];
		}

		$this->app->render('/response/json.php', $res);
	}


	public function getPosts($id) 
	{
		$result = (new Users())->getPosts($id);

		if ($result !== false) {
			$res = [
				'app' => $this->app,
                'code' => 200,
                'result' => $result
			];
		} else {
			$res = [
				'app' => $this->app,
                'code' => 404,
                'result' => ['code' => 404, 'status' => 'Not Found']
			];
		}

		$this->app->render('/response/json.php', $res);
	}


	public function all()
	{
		$json_data = (new Users())->all();

		$this->app->render('/response/json.php', [
			'app' => $this->app,
			'code' => 200,
			'result' => $json_data
		]);
	}


	public function allPosts($id)
	{
		$json_data = (new Users())->allPosts($id);

		$this->app->render('/response/json.php', [
			'app' => $this->app,
			'code' => 200,
			'result' => $json_data
		]);
    }
	
	
	public function add()
	{
		$data = json_decode($this->app->request->getBody());

		$result = (new Users())->add($data);
		
		if ($result) {
			$res = [
                'app' => $this->app,
                'code' => 201,
                'result' => ['code' => 201, 'status' => 'Created']
            ];
		} else {
            $res = [
                'app' => $this->app,
                'code' => 404,
                'result' => ['code' => 404, 'status' => 'Not Found']
            ];
		}

		$this->app->render('/response/json.php', $res);
    }
	
	
	public function update($id)
	{
		$data = json_decode($this->app->request->getBody());

		$result = (new Users())->update($id, $data);

		if ($result) {
			$res = [
                'app' => $this->app,
                'code' => 200,
                'result' => ['code' => 200, 'status' => 'Ok']
            ];
		} else {
			$res = [
                'app' => $this->app,
                'code' => 404,
                'result' => ['code' => 404, 'status' => 'Not Found']
            ];
		}

		$this->app->render('/response/json.php', $res);
	}
	
	
	public function delete($id)
	{
		$result = (new Users())->delete($id);

		if ($result) {
			$res = [
                'app' => $this->app,
                'code' => 200,
                'result' => ['code' => 200, 'status' => 'Ok']
            ];
		} else {
			$res = [
                'app' => $this->app,
                'code' => 404,
                'result' => ['code' => 404, 'status' => 'Not Found']
            ];
		}

		$this->app->render('/response/json.php', $res);
	}
}
