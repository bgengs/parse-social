<?php

namespace App\Handlers\Auth\SocialAuth\Contracts;

interface User {
	/**
	 * Get user unique identifier
	 *
	 * @return mixed
	 */
	public function getId();

	/**
	 * Get user full name
	 *
	 * @return mixed
	 */
	public function getName();

	/**
	 * get user username/nickname
	 * @return mixed
	 */
	public function getNickname();

	/**
	 * get user email address
	 *
	 * @return mixed
	 */
	public function getEmail();

	/**
	 * get user avatar
	 *
	 * @return mixed
	 */
	public function getAvatar();
}