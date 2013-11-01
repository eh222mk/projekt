<?php

require_once("src/model/Database.php");
require_once("src/model/Session.php");
require_once("src/model/NewThreadMessage.php");
require_once("src/model/CaptchaModel.php");

class NewThreadModel{
	
	public static $newThreadErrorMessage = "";
	
	/**
	 * instance of classes
	 */
	private $database;
	private $captcha;
	
	/**
	 * declares instance of classes
	 */
	public function __construct(){
		$this->database = new Database();
		$this->captcha = new CaptchaModel();
	}
	
	/**
	 * @param string title
	 * @param string content
	 * @return boolean
	 */
	public function createThread($title, $content){
		
		if($this->checkIfValidThreadContent($title, $content)){
			$session = new Session();
			$user = $session->getSessionUser();
			if($session->getIfSessionSet()){
				$this->database->insertnewThreadInDatabase($title, $content, $user);
				return true;
			}
			else{
				throw new Exception("Kan Skapa tråd om du inte är inloggad!", 1);
			}
		}
		return false;
	}
	
	/**
	 * @param string title
	 * @param string content
	 * @return boolean
	 */
	private function checkIfValidThreadContent($title, $content){
		if(!$this->captcha->checkCaptcha()){
			self::$newThreadErrorMessage = NewThreadMessage::InvalidCaptcha;
			return false;
		}
		else if($title == "" || $content == ""){
			self::$newThreadErrorMessage = NewThreadMessage::EmptyInput;
			return false;
		}
		else if(strlen($title) < 5 || strlen($title) > 50){
			self::$newThreadErrorMessage = NewThreadMessage::ErrorTitleLength;
			return false;
		}
		else if(strlen($content) < 1 || strlen($content > 500)){
			self::$newThreadErrorMessage = NewThreadMessage::ErrorContentLength;
			return false;
		}
		else if(!$this->checkSqlInjection($title, $content)){
			self::$newThreadErrorMessage = NewThreadMessage::SqlInjectionAttempt;
			return false;
		}
		else if($this->database->threadExist($title)){
			self::$newThreadErrorMessage = NewThreadMessage::ThreadExist;
			return false;
		}
		else{
			self::$newThreadErrorMessage = NewThreadMessage::NewThreadSuccess;
			return true;	
		}
	}
	
	/**
	 * @param string title
	 * @param string content
	 * @return boolean
	 */
	private function checkSqlInjection($title, $content){
		$stripTitle = strip_tags($title);
		$stripContent = strip_tags($content);
			
		if($title == strip_tags($title) && $content == strip_tags($content)){
			return true;
		}else{
			echo"Försök ej SQL injection!";
		}
		return false;
	}//end of method
}
