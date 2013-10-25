<?php

require_once("src/model/Database.php");
require_once("src/model/Session.php");

class ThreadView{
	
	private $database;
	
	private static $threadComment = "threadComment";
	private static $commentButton = "commentButton";
	
	public function __construct(){
		$this->database = new Database();
	}
	
	public function getThreadPage($thread){
		$threadContent = $this->database->getThreadContent($thread);
		$threadComments = $this->getThreadComments($thread);
		$html = "
		<div id='head'>
			<h1>Kendoforum</h1>
		</div>
		<div id='content'>
			<h2>".$threadContent->getTitle().": </h2>
			<p>".$threadContent->getContent()."</p>
			<div id='threadContent'>
				<form id='newThreadComment' action='?action=threadcomment&thread=$thread' method='POST'> 
					<p>Lägg till ny kommentar</p>
					<p><input type='text' name='".self::$threadComment."'/></p>
					<input type='submit' name='".self::$commentButton."' value='Posta'/>
				</form>
			</div>
			<a href='/php/projekt/'>Tillbaka</a>
			$threadComments
		</div>";
		return $html;
	}//end of method
	
	private function getThreadComments($thread){
		$comments = $this->database->getComments($thread);
		$html = "";
		if($comments != null){
			foreach($comments as $c){
			$html .= "<h4>".$c['User'].":</h4>
			<p>".$c['Comment']."</p></br>";
			}	
		}
		return $html;
	}//end of method
	
}//end of class
