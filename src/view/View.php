<?php

require_once("src/view/RegisterView.php");
require_once("src/view/newThreadView.php");
require_once("src/model/database.php");

class View{
	private static $loginButton = "loginButton";
	private static $loginName = "loginName";
	private static $loginPassword = "loginPassword";
	private static $logoutButton = "logoutButton";
	private static $registerButton = "registerButton";
	private static $createThreadButton = "createThreadButton";
	
	private $username = "";
	
	public function ifLoginAttempt(){
		if(isset($_POST[self::$loginButton])){
			return true;
		}
		return false;
	}
	
	public function ifLogoutAttempt(){
		if(isset($_POST[self::$logoutButton])){
			return true;
		}
		return false;
	}
	
	public function ifRegisterAttempt(){
		if(isset($_POST[self::$registerButton])){
			return true;
		}
		return false;
	}
	
	public function ifCreateThreadAttempt(){
		if(isset($_POST[self::$createThreadButton])){
			return true;
		}
		return false;
	}	
	
	public function getUsername(){
		if(isset($_POST[self::$loginName])){
			$this->userName = $_POST[self::$loginName];
			return $_POST[self::$loginName];
		}
	}
	
	public function getPassword(){
		if(isset($_POST[self::$loginPassword])){
			return $_POST[self::$loginPassword];
		}
	}
	
	private function getThreadHeaders(){
		$database = new Database();
		$threads = $database->getThreads();
		$html = "";
		$counter = 0;
		foreach($threads as $t){
			$html .= "
			<h3><a href=''>" . $t['Title'] . "</a></h3><label> av: ". $t['User'] . "</label>";
			$counter++;
		}
		return $html;
	}
	
	public function getPage($body){
		$html = "
		<header>
			<title>Kendoforum</title>
			<meta charset='UTF-8' />
			<link rel='stylesheet' type='text/css' href='projekt.css' />
		</header>
		<body>
			$body
		</body>
		<footer>
		</footer>	
		";
		return $html;
	}//end of method
	
	public function pageBodyLoggedIn(){
		$session = new Session();
		$loggedInUser = $session->getSessionContent();
		return "
		<div id='head'>
			<h1>Kendoforum</h1>
		</div>
		<div id='content'>
			<h2>Trådar: </h2>
			<form id='createThreadForm' action='?createThread' method='POST'>
				<input type='submit' value='Skapa tråd' name='" . self::$createThreadButton . "' />
			</form>" 
			. $this->getThreadHeaders() . "
			<h3>Logga in</h3>
				<p>Inloggad som $loggedInUser</p>
			<form id='logoutForm' action='?logout' method='POST'>
				<input type='submit' value='Logga ut' name='" . self::$logoutButton ."' />
			</form>
		</div>";
	}//end of method	
	
	public function getRegisterPage(){
		$RegisterView = new RegisterView();
		return $RegisterView->getRegisterPage();
	}//end of method
	
	public function getNewThreadPage(){
		$newThreadView = new NewThreadView();
		return $newThreadView->getNewThreadPage();
	}//end of method
 	
	public function pageBodyLoggedOut(){
		return "
		<div id='head'>
			<h1>Kendoforum</h1>
		</div>
		<div id='content'>
			<h2>Trådar: </h2>
			<p> </p>
			<h3>Logga in</h3>
			<div id='loginForms'>
				<form id='loginForm' action='?login' method='POST'> 
					<p>Username <input type='text' name=". self::$loginName ." /> </p>
					<p>Password <input type='password' name=". self::$loginPassword ." /> </p>
					<input type='submit' value='Logga in' name=" . self::$loginButton ." />
					<form id='rForm' action='?register' method='POST'>
						<input type='submit' value='Registrera' name=" . self::$registerButton ." />
					</form>
				</form>
			</div>
		</div>";
	}//end of method
}
