<?php

require_once("src/model/Database.php");
require_once("src/model/Session.php");

class EditThreadCommentModel{
	
	public static $editCommentErrorMessage = 0;

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
	 * @param string value
	 * @param boolean ifTitle
	 * @return boolean
	 */
	public function editThreadComment($comment, $value, $ifTitle = FALSE){
		if(strlen($value) < 1){
			self::$editCommentErrorMessage = 1;
		}else if(strlen($value) > 500){
			self::$editCommentErrorMessage = 2;
		}else if($ifTitle){
			if($this->database->getIfUserPostedThread($this->session->getSessionUser(), $comment)){
				$this->database->editTitleFromDatabase($comment, $value);
				return true;	
			}else{
				self::$editCommentErrorMessage = 3;
			}
		}else{
			if($this->database->getIfUserPostedComment($this->session->getSessionUser(), $comment)){
				$this->database->editCommentFromDatabase($comment, $value);
				return true;
			}else{
				self::$editCommentErrorMessage = 4;
			}
		}
		return false;
	}
}
