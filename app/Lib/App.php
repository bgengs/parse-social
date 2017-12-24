<?php

namespace App\Lib;

use App\Exception\ParseExceptionHandler;
use App\handlers\Handler;
use Parse\ParseClient;
use Parse\ParseException;
use Parse\ParseSessionStorage;

class App
{
	/**
	 * @var Session
	 */
	private $session;

	/**
	 * @var Request
	 */
	private $request;

	private $result;

	public function __construct()
	{
		$this->session = new Session();
		$this->request = new Request($this->session);

		$this->session->setCSRFToken();

		$this->boot();
	}

	/**
	 * Boot the app
	 *
	 * @return $this
	 */
	public function boot()
	{
		RunWithParse::run(function () {
			//get the current user (if exists)
			$this->session->setUser();
		});

		return $this;
	}

	/**
	 * Run the processor
	 *
	 * @param Handler $process
	 *
	 * @return $this
	 */
	public function run(Handler $process)
	{
		//catch any error in the app
		RunWithParse::run(function () use ($process) {
			/**
			 * Setup the instance and run
			 */
			$this->result = $process->setup($this->session, $this->request)->run();
		});

		return $this;
	}

	/**
	 * Send the result
	 *
	 * @return mixed
	 */
	public function getResult()
	{
		return $this->result;
	}

	/**
	 * check if user logged in
	 *
	 * @return mixed
	 */
	public function isLoggedIn()
	{
		return $this->session->isUserLoggedIn();
	}

	/**
	 * get the session
	 *
	 * @return Session
	 */
	public function session()
	{
		return $this->session;
	}

	/**
	 * get the request object
	 *
	 * @return Request
	 */
	public function request()
	{
		return $this->request;
	}
}