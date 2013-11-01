<?php

require_once("src/model/Database.php");
require_once("src/model/Session.php");

class loginModel{
	
	/**
	 * Value of errormessage
	 */	
	public static $errorMessage = 0;
	
	/**
	 * instance of classes
	 */
	private $database;
	private $session;
	
	/**
	 * declares instance of classes
	 */
	public function __construct(){
		$this->database = new Database();
		$this->session = new Session();
	}
	
	/**
	 * @param string username
	 * @param string password
	 * @return boolean
	 */
	public function checkUserCredential($username, $password){
		if($username == ""){
			self::$errorMessage = 1;
			return false;
		}
		else if($password == ""){
			self::$errorMessage = 2;
			return false;
		}
		else if($this->database->ifLoginSuccess($username, $password)){
			$this->session->setSession($username);
			if($this->database->ifUserAdmin($username)){
				$this->session->setSessionAdmin(true);
			}
			else{
				$this->session->setSessionAdmin(false);	
			}
			
			return true;
		}
		else{
			self::$errorMessage = 3;
		}
		return false;
	}
	
	public function doLogout(){
		$this->session->removeSession();
	}
	
	public function ifLoggedIn(){
		return $this->session->getIfSessionSet();
	}
}




