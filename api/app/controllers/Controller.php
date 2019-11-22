<?php

namespace app\controllers;

use \Slim\Slim;

class Controller 
{
	protected $app;

	function __construct() 
	{
		$this->app = Slim::getInstance();
	}
}
