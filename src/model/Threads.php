<?php

class Thread{
	
	private $title;
	private $content;
	private $user;
	private $threadTime;
	
	public function setTitle($title){
		$this->title = $title;
	}
	public function setContent($content){
		$this->content = $content;
	}
	public function setUser($user){
		$this->user = $user;
	}
	public function setTime($time){
		$this->threadTime = $time; 
	}
	
	public function getTitle(){
		return $this->title;
	}
	public function getContent(){
		return $this->content;
	}
	public function getUser(){
		return $this->user;
	}
	public function getTime(){
		return $this->threadTime;
	}
}
