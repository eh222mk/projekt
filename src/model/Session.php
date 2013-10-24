<?php

class Session{
	
	private $currentSession = "user";
	
	public function setSession($user){
		$_SESSION[$this->currentSession] = $user;
	}
	
	public function getSessionContent(){
		$user = $_SESSION[$this->currentSession];
		return $user;
	}
	
	public function removeSession(){
		unset($_SESSION[$this->currentSession]);
	}
	
	public function getIfSessionSet(){
		if(isset($_SESSION[$this->currentSession])){
			return true;
		}
		return false;
	}
}
