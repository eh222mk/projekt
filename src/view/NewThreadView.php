<?php

require_once("src/model/CaptchaModel.php");
require_once("src/recaptcha/recaptchalib.php");

class NewThreadView{
	
	private $title;
	private $content;
	
	/**
	 * Variables to avoid string dependancy
	 */
	private static $threadTitle = "threadTitle";
	private static $threadContent = "threadContentText";
	private static $submitNewThread = "newThreadButton";
	
	/**
	 * @return boolean
	 */
	public function getIfNewThreadAttempt(){
		if(isset($_POST[self::$submitNewThread])){
			return true;
		}
		return false;
	}
	
	/**
	 * @return string POST threadtitle
	 */
	public function getThreadTitle(){
		if(isset($_POST[self::$threadTitle])){
			$this->title = $_POST[self::$threadTitle];
			return $_POST[self::$threadTitle];
		}
	}
	
	/**
	 * @return string POST threadcontent
	 */
	public function getThreadContent(){
		if(isset($_POST[self::$threadContent])){
			$this->content = $_POST[self::$threadContent];
			return $_POST[self::$threadContent];
		}
	}
	
	/**
	 * @return html
	 */
	public function getNewThreadPage(){
		$errorMessage = newThreadModel::$newThreadErrorMessage;
		$this->title = $_POST[self::$threadTitle];
		$this->content = $_POST[self::$threadContent];
		return "
		<div id='content'>
			<div id='newThreadPage'>
			<h3>Ny tråd:</h3>
			<div id='newThreadErrorMessage'>$errorMessage</div>
			<form id='newThreadForm' action='?action=createNewThread' method='POST'>
				<p>Rubrik   <input type='text' id=".self::$threadTitle." name=" . self::$threadTitle . " value='$this->title'/></p>
				<p>Innehåll   <textarea id=".self::$threadContent." name=".self::$threadContent.">$this->content</textarea></p>
				".recaptcha_get_html(CaptchaModel::PublicKey)."
				<input type='submit' value='Skapa tråd' id=".self::$submitNewThread." name='" . self::$submitNewThread ."' /></p>
			</form>
			<a href='/php/projekt/'>Tillbaka</a>
			</div>
		</div>";
	}
}
