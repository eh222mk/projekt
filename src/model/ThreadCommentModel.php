<?php

require_once("src/model/Database.php");
require_once("src/model/CaptchaModel.php");

class ThreadCommentModel{
	
	/**
	 * errorvalue
	 */
	public static $error = 0;
	
	/**
	 * instance of classes
	 */
	private $database;
	private $session;
	private $captcha;
	
	/**
	 * declares instance of classes
	 */
	public function __construct(){
		$this->database = new Database();
		$this->session = new Session();
		$this->captcha = new CaptchaModel();
	}
	
	/**
	 * @param int comment
	 * @param string thread
	 * @return boolean
	 */
	public function addCommentAttempt($comment, $thread){
		if($this->ifValidComment($comment)){
			if($this->captcha->checkCaptcha()){
				$user = $this->session->getSessionUser();
				$this->database->insertNewComment($comment, $thread, $user);
				return true;
			}
			self::$error = 1;
		}
		else{
			self::$error = 2;	
		}
		return false;
	}
	
	/**
	 * @param int comment
	 * @return boolean
	 */
	private function ifValidComment($comment){
		if(strlen($comment) < 1){
			return false;
		}
		return true;
	}
}
