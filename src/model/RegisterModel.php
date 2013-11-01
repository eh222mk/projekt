<?php

require_once("src/model/database.php");
require_once("src/model/RegisterMessage.php");

class RegisterModel{
	
	/**
	 * the error value
	 */
	public static $errorMessage = "";

	/**
	 * instance of class
	 */
	private $database;	
	public function __construct(){
		$this->database = new Database();
	}
	
	/**
	 * @param UserCredential registerValues
	 * @return boolean
	 */
	public function registerUser(UserCredential $registerValues){
		$validRegister = $this->ifValidRegisterCredential($registerValues);
		if($validRegister){
			$this->database->insertUserInDatabase($registerValues);
			return true;
		}
		return false;
	}
	
	/**
	 * @param UserCredential registerValues
	 * @return boolean
	 */
	private function ifValidRegisterCredential(UserCredential $registerValues){
		$username = $registerValues->getUsername();
		$password = $registerValues->getPassword();
		$repeatPassword = $registerValues->getRepeatPassword();
		$email = $registerValues->getEmail();
		if($username == ""){
			self::$errorMessage = RegisterMessage::NoUsername;	
			return false;	
		}else if(strlen($username) < 4 || strlen($username) > 20){
			self::$errorMessage = RegisterMessage::ErrorUsernameLength;	
			return false;
		}else if(strlen($password) == ""){
			self::$errorMessage = RegisterMessage::NoPassword;
			return false;
		}else if(strlen($password) < 6 || strlen($password) > 30){
			self::$errorMessage = RegisterMessage::ErrorPasswordLength;
			return false;	
		}else if($password != $repeatPassword){
			self::$errorMessage = RegisterMessage::PasswordsNotSame;
			return false;
		}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			self::$errorMessage = RegisterMessage::ErrorEmail;
			return false;
		}else if($this->database->userExist($username)){
			self::$errorMessage = RegisterMessage::UserExist;
			return false;
		}else if($username != strip_tags($username) || $password != strip_tags($password)){
			self::$errorMessage = RegisterMessage::SqlInjection;
			return false;
		}
		return true;
	}
}
