<?php

require_once("src/model/Database.php");

class DeleteThreadModel{
	
	/**
	 * instance of class
	 */
	private $database;	
	public function __construct(){
		$this->database = new Database();
	}
	
	/**
	 * calls on deletethread
	 */
	public function deleteThread($thread){
		$this->database->deleteThreadFromDatabase($thread);
	}
}
