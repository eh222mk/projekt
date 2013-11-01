<?php

require_once("src/model/NewThreadModel.php");

class NewThreadController{
	
	/**
	 * instances of classes
	 */
	private $view;
	private $model;
	
	/**
	 * creates instances of classes
	 */
	public function __construct(){
		$this->view = new NewThreadView();
		$this->model = new NewThreadModel();
	}
	
	/**
	 * @return boolean, if succeeded
	 */
	public function newThreadAttempt(){
		if($this->view->getIfNewThreadAttempt()){
			$title = $this->view->getThreadTitle();
			$content = $this->view->getThreadContent();
			
			if($this->model->createThread($title, $content)){
				return true;
			}
		}
		return false;
	}
}
