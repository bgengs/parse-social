<?php

namespace App\handlers;

use App\Lib\Request;
use App\Lib\Session;

abstract class Handler {
	/**
	 * @var Session
	 */
	protected $session;

	/**
	 * @var Request
	 */
	protected $request;

	public function setup(Session $session, Request $request) {
		$this->session = $session;
		$this->request = $request;
		return $this;
	}

	/**
	 * Execute the jobs
	 *
	 * @return mixed
	 */
	public abstract function run();
}