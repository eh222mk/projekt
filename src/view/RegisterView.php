<?php

class RegisterView{
	/**
	 * variables to avoid string dependancy
	 */
	private static $registerUser = "registerUser";
	private static $registerUsername = "registerUsername";
	private static $registerPassword = "registerPassword";
	private static $repeatRegisterPassword = "repeatRegisterPassword";
	private static $registerEmail = "registerEmail";
	
	/**
	 * @return boolean
	 */
	public function getIfRegisterAttempt(){
		if(isset($_POST[self::$registerUser])){
			return true;
		}
		return false;
	}
	
	/**
	 * return string POST registerUsername
	 */
	public function getRegisterUsername(){
		if(isset($_POST[self::$registerUsername])){
			return $_POST[self::$registerUsername];
		}	
	}
	
	/**
	 * @return string POST registerPassword
	 */
	public function getRegisterPassword(){
		if(isset($_POST[self::$registerPassword])){
			return $_POST[self::$registerPassword];
		}
	}
	/**
	 * @return string POST registerRepeatPassword
	 */
	public function getRepeatRegisterPassword(){
		if(isset($_POST[self::$repeatRegisterPassword])){
			return $_POST[self::$repeatRegisterPassword];
		}
	}
	
	/**
	 * @return string POST registerEmail
	 */	
	public function getRegisterEmail(){
		if(isset($_POST[self::$registerEmail])){
			return $_POST[self::$registerEmail];
		}
	}
	
	/**
	 * @return html
	 */	
	public function getRegisterPage(){
		$errorMessage = "<p id='registerErrorMessage'>".RegisterModel::$errorMessage."</p>";
		return "
		<div id='content'>
			<div id='registerPage'>
			<h3>Registrera</h3>
			<form id='registerForm' action='?action=registerUser' method='POST'>
				$errorMessage
				<p>Användarnamn<input id='registerName' type='text' name=". self::$registerUsername ." /></p>
				<p>Lösenord<input type='password' id='registerPassword' name=" . self::$registerPassword ." /></p>
				<p>Repetera Lösenord<input type='password' id='registerRepeatPassword' name=" . self::$repeatRegisterPassword ." /></p>
				<p>Email<input type='text' id='registerEmail' name=" . self::$registerEmail ." /></p>
				<input type='submit' value='Registera' id='registerButton' name='" . self::$registerUser ."' /></p>
			</form>
			<a href='/php/projekt'>Tillbaka</a>
			</div>
		</div>";
	}//end of method

}
