<?php

require_once("src/model/Database.php");
require_once("src/model/Session.php");

class DeleteThreadCommentModel{
	
	/**
	 * instance of classes
	 */
	private $database;
	private $session;
	
	/**
	 * declares instance of classes
	 */
	public function __construct(){
		$this->database = new Database();
		$this->session = new Session();
	}
	
	/**
	 * @param string comment
	 */
	public function deleteThreadComment($comment){
		$comment = strip_tags($comment, "<a>");
		$user = $this->session->getSessionUser($comment); 	
		if($this->session->getIfAdmin() || $this->database->getIfUserPostedComment($user, $comment)){
			$this->database->deleteCommentFromDatabase($comment);
		}				
	}
}
