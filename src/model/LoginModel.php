<?php

require_once("src/model/Database.php");
require_once("src/model/Session.php");

class loginModel{
	
	private $database;
	private $session;
	
	public function __construct(){
		$this->database = new Database();
		$this->session = new Session();
	}
	
	public function checkUserCredential($username, $password){
		if($username == ""){
			return false;
		}
		else if($password == ""){
			return false;
		}
		else{
			$this->doLogin($username, $password);
			return true;
		}
		return false;
	}
	
	private function doLogin($username, $password){
		if($this->database->ifLoginSuccess($username, $password)){
			$this->session->setSession($username);
		}
	}
	
	public function doLogout(){
		$this->session->removeSession();
	}
	
	public function ifLoggedIn(){
		return $this->session->getIfSessionSet();
	}
}




