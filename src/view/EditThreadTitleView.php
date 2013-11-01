<?php

require_once("src/model/database.php");

class EditThreadTitleView{
	
	/**
	 * variables to avoid string dependancy
	 */	
	public static $newThreadTitle = "newThreadTitle";
	public static $editTitleButton = "editTitleButton";
	
	/**
	 * Value of editTitle
	 */
	private $editTitleValue = "";
	
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
		}
		return $returnValue;
	}
	
	/**
	 * @param string thread
	 * @return html
	 */
	public function getEditTitlePage($thread){
		$threadContent = $this->database->getTitleContent($thread);
		return  "
		<div id='content'>
			<div id='newThreadPage'>
			<h3>Editera inlägg:</h3>
			<form id='editThreadCommentForm' method='POST' action='?action=editThreadTitle&thread=$thread'>
				".$this->getErrorMessage()."
				<p>Nytt innehåll   <textarea id=".self::$newThreadTitle." name=".self::$newThreadTitle.">$threadContent</textarea></p>
				<input type='submit' value='Editera titel' id=".self::$editTitleButton." name='" . self::$editTitleButton ."' /></p>
			</form>
			<a href='/php/projekt/?action=readthread&thread=$thread'>Tillbaka</a>
			</div>
		</div>";
	}
}
