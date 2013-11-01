<?php

class Session{
	
	/**
	 * values to avoid string dependancy
	 */
	private $currentSession = "user";
	private $admin = "admin";
	
	/**
	 * set value of session¨
	 * @param string user
	 */
	public function setSession($user){
		$_SESSION[$this->currentSession] = $user;
	}
	
	/**
	 * @return string, user of current session
	 */
	public function getSessionUser(){
		if(isset($_SESSION[$this->currentSession])){
			$sessionUser = $_SESSION[$this->currentSession];
			return $sessionUser;	
		}
	}
	
	/**
	 * @param boolean boolean
	 * sets value if its an admin or not
	 */
	public function setSessionAdmin($boolean){
		$_SESSION[$this->admin] = $boolean;
	}
	
	/**
	 * @return boolean
	 */
	public function getIfAdmin(){
		if(isset($_SESSION[$this->admin]) && $_SESSION[$this->admin] == true){
			return true;
		}
		return false;
	}
	
	/**
	 * unset values in session
	 */
	public function removeSession(){
		unset($_SESSION[$this->currentSession]);
		unset($_SESSION[$this->admin]);
	}
	
	/**
	 * @return boolean
	 */
	public function getIfSessionSet(){
		if(isset($_SESSION[$this->currentSession])){
			return true;
		}
		return false;
	}
}
