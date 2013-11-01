<?php

require_once("src/view/RegisterView.php");
require_once("src/model/RegisterModel.php");
require_once("src/model/UserCredential.php");

class RegisterController{
	/**
	 * instances of classes
	 */
	private $registerView;
	private $registerModel;
	
	/**
	 * construct, creates instances of requried classes
	 */
	public function __construct(){
		$this->registerView = new RegisterView();
		$this->registerModel = new RegisterModel();
	}
	
	/**
	 * @return boolean, if register succeeded
	 */
	public function registerAttempt(){	 
		if($this->registerView->getIfRegisterAttempt()){
			$registerValues = new UserCredential();	
			$registerValues->setUsername($this->registerView->getRegisterUsername());
			$registerValues->setPassword($this->registerView->getRegisterPassword());
			$registerValues->setRepeatPassword($this->registerView->getRepeatRegisterPassword());
			$registerValues->setEmail($this->registerView->getRegisterEmail());
			
			if($this->registerModel->registerUser($registerValues)){		
				return true;	
			}
		}
		return false;
	}//end of method
}
