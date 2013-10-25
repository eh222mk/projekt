<?php

class NewThreadView{
	
	private static $threadTitle = "threadTitle";
	private static $threadContent = "threadContent";
	private static $submitNewThread = "newThreadButton";
	
	public function getIfNewThreadAttempt(){
		if(isset($_POST[self::$submitNewThread])){
			return true;
		}
		return false;
	}
	
	public function getThreadTitle(){
		if(isset($_POST[self::$threadTitle])){
			return $_POST[self::$threadTitle];
		}
	}
	
	public function getThreadContent(){
		if(isset($_POST[self::$threadContent])){
			return $_POST[self::$threadContent];
		}
	}
	
	public function getNewThreadPage(){
		return "
		<div id='head'>
			<h1>Kendoforum</h1>
		</div>
		<div id='content'>
			<h3>Ny tråd:</h3>
			<form id='newThreadForm' action='?action=createNewThread' method='POST'>
				<p>Rubrik<input type='text' name=" . self::$threadTitle . " /></p>
				<p>Innehåll<input type='textarea' name=" . self::$threadContent ." /></p>
				<input type='submit' value='Skapa tråd' name='" . self::$submitNewThread ."' /></p>
			</form>
			<a href='/php/projekt/'>Tillbaka</a>
		</div>";
	}
}
