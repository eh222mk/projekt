<?php

require_once("src/model/Database.php");

class ThreadCommentModel{
	
	private $database;
	private $session;
	public function __construct(){
		$this->database = new Database();
		$this->session = new Session();
	}
	
	public function addCommentAttempt($comment, $thread){
		if($this->ifValidComment($comment)){
			$user = $this->session->getSessionContent();
			$this->database->insertNewComment($comment, $thread, $user);
		}
		
	}
	
	private function ifValidComment($comment){
		if(strlen($comment) < 1){
			return false;
		}
		return true;
	}
	
}
