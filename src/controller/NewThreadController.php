<?php

require_once("src/controller/NewThreadController.php");
require_once("src/model/NewThreadModel.php");

class NewThreadController{
	
	private $view;
	private $model;
	
	public function __construct(){
		$this->view = new NewThreadView();
		$this->model = new NewThreadModel();
	}
	
	public function newThreadAttempt(){
		if($this->view->getIfNewThreadAttempt()){
			$title = $this->view->getThreadTitle();
			$content = $this->view->getThreadContent();
			
			$this->model->createThread($title, $content);
		}
	}
}
