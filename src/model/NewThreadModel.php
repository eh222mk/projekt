<?php

require_once("src/model/Database.php");
require_once("src/model/Session.php");

class NewThreadModel{
	
	private $database;
	
	public function __construct(){
		$this->database = new Database();
	}
	
	public function createThread($title, $content){
		
		if($this->checkIfValidThreadContent($title, $content)){
			$session = new Session();
			$user = $session->getSessionContent();
			if($session->getIfSessionSet()){
				$this->database->insertnewThreadInDatabase($title, $content, $user);
			}
			else{
				die("Kan Skapa tråd om du inte är inloggad!");
			}
		}
	}
	
	private function checkIfValidThreadContent($title, $content){
		if($title == "" || $content == ""){
			echo"Inget av värderna får vara tomma!";
			return false;
		}
		if(strlen($title) < 5 || strlen($title) > 50){
			echo"Titeln måste vara melnna 5 och 50 tecken!";
			return false;
		}
		if(strlen($content) < 1 || strlen($content > 500)){
			echo"innehållet får inte vara över 500 tecken!";
			return false;
		}
		if($this->checkSqlInjection($title, $content)){
			return true;
		}
		return false;
	}
	
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
