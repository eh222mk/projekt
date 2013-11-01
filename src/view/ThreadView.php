<?php

require_once("src/model/Database.php");
require_once("src/model/Session.php");
require_once("src/model/CaptchaModel.php");
require_once("src/recaptcha/recaptchalib.php");

class ThreadView{
	
	/**
	 * Variables to avoid string dependancy
	 */
	private static $threadComment = "threadComment";
	private static $commentButton = "commentButton";
	private static $deleteId = "commentDeleteLink";
	
	public static $user = "User";
	private static $comment = "Comment";
	private static $commentID = "commentID";
	
	/**
	 * Instances of classes
	 */
	private $database;
	private $session;
	
	/**
	 * declare instances of required classes
	 */
	public function __construct(){
		$this->database = new Database();
		$this->session = new Session();
	}//end of method
	
	/**
	 * @return string
	 */
	public function getThreadComment(){
		return self::$threadComment;
	}//end of method
	
	/**
	 * @return string
	 */
	public function getCommentButton(){
		return self::$commentButton;
	}//end of method
	
	/**
	 * @return string POST
	 */
	private function getCommentContent(){
		if(isset($_POST[self::$threadComment])){
			return $_POST[self::$threadComment];
		}
		return "";
	}//end of method
	
	/**
	 * @param string $thread
	 * @return html
	 */
	public function getThreadPage($thread){
		$threadContent = $this->database->getThreadContent($thread);
		$threadComments = $this->getThreadComments($thread);
		$html = "
		<div id='content'>
			<div id='threadPage'>
			<h2>".$threadContent->getTitle().": </h2>
			<div id='threadContentTitle'>
			<h4>".$threadContent->getUser().":</h4>
			 <p>".$threadContent->getContent()."</p>";
		if($this->session->getSessionUser() == $threadContent->getUser()){
			$html .= "<a href='?action=editThreadTitle&thread=".$threadContent->getTitle()."'>Editera</a>";
		}
		$html .= "</div>
			<div id='threadContent'>
				".$this->checkIfLoggedInUser($thread)."
			</div>
			<a href='/php/projekt/'>Tillbaka</a>
			$threadComments
			</div>
		</div>";
		$this->comment = "";
		return $html;
	}//end of method
	
	/**
	 * @return string
	 */
	private function getCommentErrorMessage(){
		$error = ThreadCommentModel::$error;
		switch($error){
			case 1: $error = "Felaktig Captcha"; break;
			case 2: $error = "Felaktig Kommentar! Måste vara mellan 1 och 500 tecken."; break;
			default: $error = ""; break;
		}
		return $error;
	}//end of method
	
	/**
	 * @param string $thread
	 */
	private function checkIfLoggedInUser($thread){
		if($this->session->getIfSessionSet()){
			$comment = $this->getCommentContent();
			return " <form action='?action=threadcomment&thread=$thread' method='POST'> 
						<p>Lägg till ny kommentar:</p>
						<label>".$this->getCommentErrorMessage()."</label>
						<p><textarea id=".self::$threadComment." name='".self::$threadComment."' >$comment</textarea></p>
						".recaptcha_get_html(CaptchaModel::PublicKey)."
						<input type='submit' id=".self::$commentButton." name='".self::$commentButton."' value='Posta kommentar'/>
					</form>";
		}
		else{
			return "";
		}
	}//end of method
	
	/**
	 * @param $thread string
	 * @param $c database comments
	 * @return html
	 */
	private function adminOutput($c, $thread){
		if($this->session->getSessionUser() == $c[self::$user]){
			return "<div id='userComment'>
					<h4>".$c[self::$user].":</h4> 
					<p>".$c[self::$comment]."<a id='".self::$deleteId."' href='?action=deleteThreadComment&thread=".$thread."&comment=".$c[self::$commentID]."'>Radera</a>
						<a href='?action=editThreadComment&thread=".$thread."&comment=".$c[self::$commentID]."'>Editera</a>
					  </p></br></div>";
		}
		else{
			return "<div id='userComment'>
			<h4>".$c[self::$user].":</h4>
			<p>".$c[self::$commentID]."<a href='?action=deleteThreadComment&thread=".$thread."&comment=".$c[self::$commentID]."'>Radera</a></p></br>
			</div>";
		}
	}//end of method
	
	/**
	 * @param $c database comments
	 * @param $thread string
	 * @return html
	 */
	private function userOutput($c, $thread){
		if($this->session->getSessionUser() == $c[self::$user]){
			return "<p>".$c[self::$comment]."<a id='".self::$deleteId."' href='?action=deleteThreadComment&thread=".$thread."&comment=".$c['commentID']."'>Radera
					  </a><a href='?action=editThreadComment&thread=".$thread."&comment=".$c[self::$commentID]."'>Editera</a>
					  </p></br></div>";
		}
		else{
			return "<p>".$c[self::$comment]."</p></br>
			</div>";
		}
	}//end of method
	
	/**
	 * @param string $thread
	 * @return html
	 */
	private function getThreadComments($thread){
		$comments = $this->database->getComments($thread);
		$html = "<div id='threadComments'>";
		if($comments != null){
			if($this->session->getIfAdmin()){
				foreach($comments as $c){
					$html .= $this->adminOutput($c, $thread);
				}
			}
			else{
				foreach($comments as $c){
					$html .= "<div id='userComment' >
					<h4>".$c[self::$user].":</h4>";
					$html .= $this->userOutput($c, $thread);
				}
			}	
		}
		$html .= "</div>";
		return $html;
	}//end of method
	
}//end of class
