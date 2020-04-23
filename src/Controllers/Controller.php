<?php

namespace App\Controllers;

class Controller 
{
	protected $app;

	function __construct() 
	{
		$this->app = \Slim\Slim::getInstance();
	}
}
