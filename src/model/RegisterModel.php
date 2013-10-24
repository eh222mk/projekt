<?php

require_once("src/model/database.php");

class RegisterModel{
	
	private $database;
	
	public function __construct(){
		$this->database = new Database();
	}
	
	public function registerUser(UserCredential $registerValues){
		$validRegister = $this->ifValidRegisterCredential($registerValues);
		if($validRegister){
			$this->database->insertUserInDatabase($registerValues);
			//@TODO fix so page doesn't reload back to first page.
			//return true;
		}
		//return false;
	}
	
	private function ifValidRegisterCredential(UserCredential $registerValues){
		$username = $registerValues->getUsername();
		$password = $registerValues->getPassword();
		$repeatPassword = $registerValues->getRepeatPassword();
		$email = $registerValues->getEmail();

		if($username == ""){
			echo "Var vänlig ange ett Användarnamn!";
			return false;	
		}
		else if(strlen($username) < 4 || strlen($username) > 20){
			echo "felaktigt användarnamn! Måste vara mellan 4 och 20 tecken!";
			return false;
		}
		if(strlen($password) == ""){
			echo "Var vänlig ange ett lösenord!";
			return false;
		}
		else if(strlen($password) < 6 || strlen($password) > 30){
			echo "felaktigt Lösenord! Måste vara mellan 6 och 30 tecken!";
			return false;	
		}
		else if($password != $repeatPassword){
			echo "Lösenorden stämmer inte överens! Var vänlig försök igen!";
			return false;
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			echo "Emailadressen är inte giltig!";
			return false;
		}
		return true;
	}
}
