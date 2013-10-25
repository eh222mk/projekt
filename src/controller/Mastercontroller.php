<?php

require_once("src/view/View.php");
require_once("src/model/LoginModel.php");
require_once("src/controller/RegisterController.php");
require_once("src/controller/NewThreadController.php");
require_once("src/model/ThreadCommentModel.php");

class Mastercontroller{
	
	private $view;
	private $loginModel;
	private $registerController;
	private $newThreadController;
	private $threadCommentModel;
	
	private $html = "";
	
	public function __construct(){
		$this->view = new View();
		$this->loginModel = new LoginModel();
		$this->registerController = new registerController();
		$this->newThreadController = new NewThreadController();
		$this->threadCommentModel = new ThreadCommentModel();
	}//end of method
	
	public function startApplication(){
		var_dump($_POST);
		$action = $this->view->getAction();
		switch($action){
			case "readthread": $this->getThread(); break;
			case "login": $this->loginAttempt(); break;
			case "logout": $this->logoutAttempt(); break;
			case "register": $this->registerAttempt(); break;
			case "createNewThread": $this->newThreadAttempt(); break;
			case "threadcomment": $this->newCommentAttempt(); break;
			default: $this->ifLoggedIn(); break; 
		}
		$this->html = $this->view->getPage($this->html);
		return $this->html;
	}//end of method
	
	private function newCommentAttempt(){
		$thread = $this->view->getThread();
		$threadComment = $this->view->getThreadComment();
		$this->threadCommentModel->addCommentAttempt($threadComment, $thread);
		$this->html = $this->view->getThreadPage($thread);		
	}
	
	private function getThread(){
		$thread = $this->view->getThread();
		$this->html = $this->view->getThreadPage($thread);
	}
	
	private function loginAttempt(){
		if($this->loginController()){
			$this->html = $this->view->pageBodyLoggedIn(); 
		}
		else{
			$this->html = $this->view->PageBodyLoggedOut();
		}
	}
	
	private function logoutAttempt(){
		$this->loginModel->doLogout();
		$this->html = $this->view->PageBodyLoggedOut();
		
	}
	
	private function ifLoggedIn(){
		if($this->loginModel->ifLoggedIn()){
			$this->html = $this->view->pageBodyLoggedIn(); 
		}
		else{
			$this->html = $this->view->PageBodyLoggedOut();
		}
	}
	
	private function registerAttempt(){
		$this->registerController->registerAttempt();
		if($this->view->ifRegisterAttempt()){
			$this->html = $this->view->getRegisterPage();
			return true;
		}
	}
	
	private function newThreadAttempt(){
		$this->newThreadController->newThreadAttempt();
		if($this->view->ifCreateThreadAttempt()){
			$this->html = $this->view->getNewThreadPage();
			return true;
		}
		return false;
	}
	
	private function loginController(){
		$username = $this->view->getUsername();
		$password = $this->view->getPassword();
		$ifLoginSuccess = $this->loginModel->checkUserCredential($username, $password);
		return $ifLoginSuccess;
	}//end of method
	
	
}
