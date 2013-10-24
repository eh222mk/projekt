<?php

class RegisterView{

	private static $registerUser = "registerUser";
	private static $registerUsername = "registerUsername";
	private static $registerPassword = "registerPassword";
	private static $repeatRegisterPassword = "repeatRegisterPassword";
	private static $registerEmail = "registerEmail";
	
	public function getIfRegisterAttempt(){
		if(isset($_POST[self::$registerUser])){
			return true;
		}
		return false;
	}
	
	public function getRegisterUsername(){
		if(isset($_POST[self::$registerUsername])){
			return $_POST[self::$registerUsername];
		}	
	}
	public function getRegisterPassword(){
		if(isset($_POST[self::$registerPassword])){
			return $_POST[self::$registerPassword];
		}
	}
	public function getRepeatRegisterPassword(){
		if(isset($_POST[self::$repeatRegisterPassword])){
			return $_POST[self::$repeatRegisterPassword];
		}
	}
	public function getRegisterEmail(){
		if(isset($_POST[self::$registerEmail])){
			return $_POST[self::$registerEmail];
		}
	}
	
	public function getRegisterPage(){
		return "
		<div id='head'>
			<h1>Kendoforum</h1>
		</div>
		<div id='content'>
			<h3>Registrera</h3>
			<form id='registerForm' action='?registerUser' method='POST'>
				<p>Användarnamn<input type='text' name=". self::$registerUsername ." /></p>
				<p>Lösenord<input type='password' name=" . self::$registerPassword ." /></p>
				<p>Repetera Lösenord<input type='password' name=" . self::$repeatRegisterPassword ." /></p>
				<p>Email<input type='text' name=" . self::$registerEmail ." /></p>
				<input type='submit' value='Registera' name='" . self::$registerUser ."' /></p>
			</form>
			<a href=''>Tillbaka</a>
		</div>";
	}//end of method

}
