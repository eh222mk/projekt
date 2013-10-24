<?php

require_once("src/view/RegisterView.php");
require_once("src/model/RegisterModel.php");
require_once("src/model/UserCredential.php");

class RegisterController{
	
	private $registerView;
	private $registerModel;
	
	public function __construct(){
		$this->registerView = new RegisterView();
		$this->registerModel = new RegisterModel();
	}
	
	public function registerAttempt(){	 
		if($this->registerView->getIfRegisterAttempt()){
			$registerValues = new UserCredential();	
			$registerValues->setUsername($this->registerView->getRegisterUsername());
			$registerValues->setPassword($this->registerView->getRegisterPassword());
			$registerValues->setRepeatPassword($this->registerView->getRepeatRegisterPassword());
			$registerValues->setEmail($this->registerView->getRegisterEmail());
			
			$this->registerModel->registerUser($registerValues);
		}
	}
}
