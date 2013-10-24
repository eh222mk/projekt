<?php

class UserCredential{
	
	private $username = "";
	private $password = "";
	private $repeatPassword = "";
	private $email = "";
	
	public function getUsername(){
		return $this->username;		
	}
	public function getPassword(){
		return $this->password;		
	}
	public function getRepeatPassword(){
		return $this->repeatPassword;		
	}
	public function getEmail(){
		return $this->email;		
	}

	public function setUsername($username){
		$this->username = $username;
	}
	public function setPassword($password){
		$this->password = $password;
	}
	public function setRepeatPassword($repeatPassword){
		$this->repeatPassword = $repeatPassword;
	}
	public function setEmail($email){
		$this->email = $email;
	}
}
