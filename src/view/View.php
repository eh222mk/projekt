<?php

require_once("src/view/RegisterView.php");
require_once("src/view/newThreadView.php");
require_once("src/view/ThreadView.php");
require_once("src/view/EditThreadCommentView.php");
require_once("src/view/EditThreadTitleView.php");
require_once("src/model/database.php");
require_once("src/model/Session.php");

class View{
	/**
	 * variables to avoid string dependency
	 */
	private static $loginButton = "loginButton";
	private static $loginName = "loginName";
	private static $loginPassword = "loginPassword";
	private static $logoutButton = "logoutButton";
	private static $registerButton = "registerButton";
	private static $createThreadButton = "createThreadButton";
	private static $thread = "thread";
	private static $comment = "comment";
	private static $action = "action";
	
	private static $threadViewUser;
	private static $threadViewTitle = "Title";
	
	/**
	 * content of usernameInput and loginErroMessage
	 */
	private $username = "";
	private $loginErrorMessage = "";
	private $newThreadView;
	/**
	 * Feedback from when failing to creat a new thread
	 */
	private static $threadComment;
	public function __construct(){
		$this->threadView = new ThreadView();
		self::$threadComment = $this->threadView->getThreadComment();
		self::$threadViewUser = ThreadView::$user;
		$this->newThreadView = new NewThreadView();
	}
	
	/**
	 * set value of loginErrorMessage
	 */
	public function setLoginErrorMessage(){
		$errorMessage = LoginModel::$errorMessage;
		switch($errorMessage){
			case 0: $this->loginErrorMessage = ""; break;
			case 1: $this->loginErrorMessage = "<p id='loginErrorMessage'>Måste skriva in användarnamn</p>"; break;
			case 2: $this->loginErrorMessage = "<p id='loginErrorMessage'>Måste skriva in lösenord</p>"; break;
			case 3: $this->loginErrorMessage = "<p id='loginErrorMessage'>Felaktiga inloggningsuppgifter</p>"; break;
			default: $this->loginErrorMessage = ""; break;
		} 
	}
	
	/**
	 * @return $_POST, value of new comment
	 */
	public function getNewCommentValue(){
		if(isset($_POST[EditThreadCommentView::$newThreadContent])){
			return $_POST[EditThreadCommentView::$newThreadContent];
		}
	}
	
	/**
	 * @return $_POST, value of new comment after edit
	 */	
	public function getIfEditCommentAttempt(){
		if(isset($_POST[EditThreadCommentView::$editCommentButton])){
			return true;
		}
		return false;
	}
	
	/**
	 * @return $_POST, the value of newTitle
	 */
	public function getNewTitleValue(){
		if(isset($_POST[EditThreadTitleView::$newThreadTitle])){
			return $_POST[EditThreadTitleView::$newThreadTitle];
		}
	}
	
	/**
	 * @return boolean
	 */
	public function getIfEditTitleAttempt(){
		if(isset($_POST[EditThreadTitleView::$editTitleButton])){
			return true;
		}
		return false;
	}
	
	/**
	 * @return $_GET action
	 */
	public function getAction(){
		if(isset($_GET[self::$action])){
			return $_GET[self::$action];
		}
		return null;
	}
	
	/**
	 * @return GET thread
	 */
	public function getThread(){
		if(isset($_GET[self::$thread])){
			return $_GET[self::$thread];
		}
		return null;
	}
	
	/**
	 * @return GET comment
	 */
	public function getComment(){
		if(isset($_GET[self::$comment])){
			return $_GET[self::$comment];
		}
		return null;
	}
	
	/**
	 * @return POST threadComment
	 */
	public function getThreadComment(){
		if(isset($_POST[self::$threadComment])){
			return $_POST[self::$threadComment];
		}
	}
	
	/**
	 * @return boolean
	 */
	public function ifLoginAttempt(){
		if(isset($_POST[self::$loginButton])){
			return true;
		}
		return false;
	}
	
	/**
	 * @return boolean
	 */
	public function ifLogoutAttempt(){
		if(isset($_POST[self::$logoutButton])){
			return true;
		}
		return false;
	}
	
	/**
	 * @return boolean
	 */
	public function ifRegisterAttempt(){
		if(isset($_POST[self::$registerButton])){
			return true;
		}
		return false;
	}
	
	/**
	 * @return boolean
	 */
	public function ifCreateThreadAttempt(){
		if(isset($_POST[self::$createThreadButton])){
			return true;
		}
		return false;
	}	
	
	/**
	 * @return POST loginName
	 */
	public function getUsername(){
		if(isset($_POST[self::$loginName])){
			$this->username = $_POST[self::$loginName];
			return $_POST[self::$loginName];
		}
	}
	
	/**
	 * @return POST LoginPassword
	 */
	public function getPassword(){
		if(isset($_POST[self::$loginPassword])){
			return $_POST[self::$loginPassword];
		}
	}
	
	/**
	 * @return html
	 */
	private function getThreadHeaders(){
		$session = new Session();
		$database = new Database();
		$threads = $database->getThreads();
		$html = "";
		$counter = 0;
		if($session->getIfAdmin()){
			foreach($threads as $t){
				$html .= $this->headerOutput($t, true);
				$counter++;
			}
		}
		else{
			foreach($threads as $t){
				if($database->getIfUserPostedThread($session->getSessionUser(), $t[self::$threadViewTitle])){
					$html .= $this->headerOutput($t, true);	
				}
				else{
					$html .= $this->headerOutput($t, false);
				}
				$counter++;
			}
		}
		return $html;
	}
	
	/**
	 * 	@return html
	 */
	private function headerOutput($t, $ifDeleteOption){
		if($ifDeleteOption){
			return "<div id='threadHeader'><h3><a id='threadLink' href='?action=readthread&thread=".$t[self::$threadViewTitle]."'>" . $t[self::$threadViewTitle] . "</a></h3>
				  	<label id='threadLinkUser'> av: ". $t[self::$threadViewUser] . "</label> 
				  	<a id='deleteLink' href='?action=deletethread&thread=".$t[self::$threadViewTitle]."'>Delete</a> </div>";
				  	
		}
		else{
			return "<div id='threadHeader'><h3><a id='threadLink' href='?action=readthread&thread=".$t[self::$threadViewTitle]."'>" . $t[self::$threadViewTitle] . "</a></h3>
						  <label id='threadLinkUser'> av: ". $t[self::$threadViewUser] . "</label></div>";
		}
	}
	
	/**
	 * @PARAM html Body
	 * @return html
	 */
	public function getPage($body){
		$html = "
		<header>
			<title>Kendoforum</title>
			<meta charset='UTF-8' />
			<link rel='stylesheet' type='text/css' href='projekt.css' />
		</header>
		<div id='container'>
		<div id='head'>
			<h1 id='headertext'>Kendoforum</h1>
		</div>
		<body>
			$body
		</body>
		<footer>
			<script type='text/javascript' src='script/DeleteConfirm.js'></script>
		</footer>
		</div>
		";
		return $html;
	}//end of method
	
	/**
	 * @return html
	 */
	public function pageBodyLoggedIn(){
		$session = new Session();
		$loggedInUser = $session->getSessionUser();
		return "
		<div id='content'>
			<h3>Inloggad som $loggedInUser</h3>
				<form id='logoutForm' action='?action=logout' method='POST'>
					<input type='submit' value='Logga ut' name='" . self::$logoutButton ."' />
				</form>
			<h2>Trådar: </h2>
			<form id='createThreadForm' action='?action=createthread' method='POST'>
				<input type='submit' value='Skapa tråd' name='" . self::$createThreadButton . "' />
			</form>" 
			. $this->getThreadHeaders() . "
		</div>";
	}//end of method	
	
	/**
	 * @return html
	 */
	public function pageBodyLoggedOut(){
		return "
		<div id='content'>
			<div id='threads'>
				<h2>Trådar: </h2>
				". $this->getThreadHeaders() . "
			</div>
			<div id='loginForms'>
				<h3>Logga in</h3>
				<form id='loginForm' action='?action=login' method='POST'> 
					<p>Username <input type='text' name=". self::$loginName ." value='$this->username'/> </p>
					<p>Password <input type='password' name=". self::$loginPassword ." /> </p>
					$this->loginErrorMessage
					<input type='submit' value='Logga in' name=" . self::$loginButton ." />
				</form>
				<form id='rForm' action='?action=register' method='POST'>
					<input type='submit' value='Registrera' id='submitButton' name=" . self::$registerButton ." />
				</form>
			</div>
		</div>";
	}//end of method

	/**
	 * @return html
	 */		
	public function getRegisterPage(){
		$RegisterView = new RegisterView();
		return $RegisterView->getRegisterPage();
	}//end of method

	/**
	 * @return html
	 */		
	public function getNewThreadPage(){
		return $this->newThreadView->getNewThreadPage();
	}//end of method

	/**
	 * @return html
	 */	 	
 	public function getThreadPage($thread){
 		$threadView = new ThreadView();
		return $threadView->getThreadPage($thread);
 	}

 	/**
	 * @return html
	 */		
	public function getEditThreadCommentPage(){
		$editThreadCommentView = new EditThreadCommentView();
		$thread = $this->getThread();
		$comment = $this->getComment();
		return $editThreadCommentView->getEditCommentPage($thread, $comment);
	}
	
	/**
	 * @return html
	 */	
	public function getEditThreadTitlePage(){
		$editThreadTitleView = new EditThreadTitleView();
		$thread = $this->getThread();
		return $editThreadTitleView->getEditTitlePage($thread);
	}	
}