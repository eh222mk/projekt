<?php

require_once("src/view/View.php");
require_once("src/model/LoginModel.php");
require_once("src/controller/RegisterController.php");
require_once("src/controller/NewThreadController.php");

class Mastercontroller{
	
	private $view;
	private $loginModel;
	private $registerController;
	private $newThreadController;
	
	private $html = "";
	
	public function __construct(){
		$this->view = new View();
		$this->loginModel = new LoginModel();
		$this->registerController = new registerController();
		$this->newThreadController = new NewThreadController();
	}//end of method
	
	public function startApplication(){
		$pages = $this->otherPages();
		
		if(!$pages){
			if($this->view->ifLoginAttempt()){
				$this->loginController();
			}
			if($this->view->ifLogoutAttempt()){
				$this->loginModel->doLogout();
			}
			if($this->loginModel->ifLoggedIn()){
				$this->html = $this->view->pageBodyLoggedIn();	
			}
			else{
				$this->html = $this->view->pageBodyLoggedOut();
			}
			$this->html = $this->view->getPage($this->html);		
		}
		return $this->html;
	}//end of method
	
	private function otherPages(){
		$this->registerController->registerAttempt();
		if($this->view->ifRegisterAttempt()){
			$this->html = $this->view->getRegisterPage();
			$this->html = $this->view->getPage($this->html);
			return true;
		}
		$this->newThreadController->newThreadAttempt();
		if($this->view->ifCreateThreadAttempt()){
			$this->html = $this->view->getNewThreadPage();
			$this->html = $this->view->getPage($this->html);
			return true;
		}
		
		return false;
	}
	
	private function loginController(){
		$username = $this->view->getUsername();
		$password = $this->view->getPassword();
		
		$ifLoginSuccess = $this->loginModel->checkUserCredential($username, $password);
	}//end of method
	
	
}
