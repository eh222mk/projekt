<?php

require_once("src/model/database.php");

class EditThreadCommentView{
	
	/**
	 * Variables to avoid string dependancy
	 */
	public static $newThreadContent = "newThreadContent";
	public static $editCommentButton = "editCommentButton";
	
	/**
	 * value of editComment
	 */
	private $editCommentValue = "";
	
	/**
	 * instance of class
	 */
	private $database;
	
	/**
	 * declares instance of classes
	 */
	public function __construct(){
		$this->database = new Database();
	}
	
	/**
	 * @return string
	 */
	private function getErrorMessage(){
		$errorMessage = EditThreadCommentModel::$editCommentErrorMessage;
		$returnValue = "";
		switch($errorMessage){
			case 0: $returnValue = ""; break;
			case 1: $returnValue = "<p id='newThreadErrorMessage'>Innehållet får inte vara tomt!</p>"; break;
			case 2: $returnValue = "<p id='newThreadErrorMessage'>Får inte vara över 500 tecken.</p>"; break;
			case 3: $returnValue = "<p id='newThreadErrorMessage'>Du kan inte ändra andras trådar!!</p>"; break;
			case 4: $returnValue = "<p id='newThreadErrorMessage'>Du kan inte ändra andras kommentarer!!</p>"; break;
		}
		return $returnValue;
	}
	
	/**
	 * @param string thread
	 * @param int comment
	 * @return html
	 */
	public function getEditCommentPage($thread, $comment){
		$commentContent = $this->database->getCommentContent($comment);
		return  "
		<div id='content'>
			<div id='newThreadPage'>
			<h3>Editera inlägg:</h3>
			<form id='editThreadCommentForm' method='POST' action='?action=editThreadComment&thread=$thread&comment=$comment'>
				".$this->getErrorMessage()."
				<p>Nytt innehåll   <textarea id=".self::$newThreadContent." name=".self::$newThreadContent.">$commentContent</textarea></p>
				<input type='submit' value='Editera inlägg' id=".self::$editCommentButton." name='" . self::$editCommentButton ."' /></p>
			</form>
			<a href='/php/projekt/?action=readthread&thread=$thread'>Tillbaka</a>
			</div>
		</div>";
	}
}
