<?php

require_once("src/view/View.php");
require_once("src/controller/RegisterController.php");
require_once("src/controller/NewThreadController.php");
require_once("src/model/LoginModel.php");
require_once("src/model/ThreadCommentModel.php");
require_once("src/model/DeleteThreadModel.php");
require_once("src/model/DeleteThreadCommentModel.php");
require_once("src/model/EditThreadCommentModel.php");
require_once("src/model/Session.php");
require_once("src/model/Database.php");
require_once("src/view/Redirect.php");

class Mastercontroller{
	
	/**
	 * Declaration of classes
	 */
	private $view;
	private $loginModel;
	private $registerController;
	private $newThreadController;
	private $threadCommentModel;
	private $session;
	private $redirect;
	
	/**
	 * the html value that will be returned
	 */
	private $html = "";
	
	/**
	 * Construct
	 * Creates instances of required classes
	 */
	public function __construct(){
		$this->view = new View();
		$this->loginModel = new LoginModel();
		$this->registerController = new registerController();
		$this->newThreadController = new NewThreadController();
		$this->threadCommentModel = new ThreadCommentModel();
		$this->session = new Session();
		$this->redirect = new Redirect();
	}//end of method
	
	/**
	 * Starts application, works as a switch
	 * @RETURN html
	 */
	public function startApplication(){
		$action = $this->view->getAction();
		switch($action){
			case "readthread": $this->getThread(); break;
			case "login": $this->loginAttempt(); break;
			case "logout": $this->logoutAttempt(); break;
			case "register": $this->registerAttempt(); break;
			case "registerUser": $this->registerUserAttempt(); break;
			case "createthread": $this->newThreadAttempt(); break;
			case "createNewThread": $this->createNewThreadAttempt(); break;
			case "threadcomment": $this->newCommentAttempt(); break;
			case "deletethread": $this->deleteThreadAttempt(); break;
			case "deleteThreadComment": $this->deleteThreadComment(); break;
			case "editThreadComment": $this->editThreadComment(); break;
			case "editThreadTitle": $this->editThreadTitle(); break;
			default: $this->ifLoggedIn(); break; 
		}
		$this->html = $this->view->getPage($this->html);
		return $this->html;
	}//end of method
	
	/**
	 * set html depending on user is logged in or not.
	 */
	private function ifLoggedIn(){
		if($this->loginModel->ifLoggedIn()){
			$this->html = $this->view->pageBodyLoggedIn(); 
		}
		else{
			$this->html = $this->view->PageBodyLoggedOut();
		}
	}//end of method
	
	/**
	 * get the thread the user is reading
	 */
	private function getThread(){
		$thread = $this->view->getThread();
		$this->html = $this->view->getThreadPage($thread);
	}//end of method
	
	/**
	 * check if user logged in or trying to log in
	 */
 	private function loginAttempt(){
		if($this->loginModel->ifLoggedIn()){
			$this->html = $this->view->pageBodyLoggedIn();
		}
		else{
			if($this->loginController()){
				$this->html = $this->view->pageBodyLoggedIn(); 
			}
			else{
				$this->html = $this->view->PageBodyLoggedOut();
			}
		}
	}//end of method
	
	/**
	 * Try to login
	 */
	private function loginController(){
		$username = $this->view->getUsername();
		$password = $this->view->getPassword();
		$ifLoginSuccess = $this->loginModel->checkUserCredential($username, $password);
		$this->view->setLoginErrorMessage();
		return $ifLoginSuccess;
	}//end of method
	
	/**
	 * Try to logout
	 */
	private function logoutAttempt(){
		$this->loginModel->doLogout();
		$this->html = $this->view->PageBodyLoggedOut();
	}//end of method

	/**
	 * If user wants to register a new user
	 */
	private function registerAttempt(){
		if($this->view->ifRegisterAttempt()){
			$this->html = $this->view->getRegisterPage();
		}
	}//end of method
	
	/**
	 * User tries to register.
	 */
	private function registerUserAttempt(){
		if($this->registerController->registerAttempt()){
			$this->redirect->backToMain();
		}
		else{
			$this->html = $this->view->getRegisterPage();
		}
	}//end of method
	
	/**
	 * Attempts to create a new comment
	 */
	private function newCommentAttempt(){
		$thread = $this->view->getThread();
		$threadComment = $this->view->getThreadComment();
		if($this->threadCommentModel->addCommentAttempt($threadComment, $thread)){
			$this->redirect->backToThread($thread);	
		}
		$this->getThread();
	}//end of method
	
	/**
	 * Present createnewthread view if user wants to create a new thread
	 */
	private function createNewThreadAttempt(){
		if($this->newThreadController->newThreadAttempt()){
			$this->redirect->backToMain();
		}
		else{
			$this->html = $this->view->getNewThreadPage();
		}
	}//end of method
	
	/**
	 * User tries to create a new thread
	 */
	private function newThreadAttempt(){
		if($this->view->ifCreateThreadAttempt()){
			$this->html = $this->view->getNewThreadPage();
		}
	}//end of method
	
	/**
	 * User attempts to delete a thread
	 */
	private function deleteThreadAttempt(){
		$database = new Database();
		$deleteThreadModel = new DeleteThreadModel();
		$thread = $this->view->getThread();
		$user = $this->session->getSessionUser();
		if($this->session->getIfAdmin() || $database->getIfUserPostedThread($user, $thread)){
			$deleteThreadModel->deleteThread($thread);	
		}
		$this->ifLoggedIn();
	}//end of method
	
	/**
	 * user attempts to delete a comment
	 */
	private function deleteThreadComment(){
		$deleteThreadCommentModel = new DeleteThreadCommentModel();
		$comment = $this->view->getComment();
		$deleteThreadCommentModel->deleteThreadComment($comment);
		$this->getThread();
	}//end of method	
	
	/**
	 * User tries to edit current comment
	 */
	private function editThreadComment(){
		if($this->session->getIfSessionSet()){
			if($this->view->getIfEditCommentAttempt()){
				$editThreadCommentModel = new EditThreadCommentModel();
				
				$comment = $this->view->getComment();
				$newCommentValue = $this->view->getNewCommentValue();
				if($editThreadCommentModel->editThreadComment($comment, $newCommentValue)){
					$this->getThread();	
				}
				else{
					$this->html = $this->view->getEditThreadCommentPage();
				}
			}
			else{
				$this->html = $this->view->getEditThreadCommentPage();	
			}
		}
		else{
			$this->ifLoggedIn();
		}
	}//end of method

	/**
	 * User tries to edit the content in the thread
	 */	
	private function editThreadTitle(){
		if($this->session->getIfSessionSet()){
			if($this->view->getIfEditTitleAttempt()){
				$editThreadCommentModel = new EditThreadCommentModel();
				
				$thread = $this->view->getThread();
				$newTitleValue = $this->view->getNewTitleValue();
				if($editThreadCommentModel->editThreadComment($thread, $newTitleValue, TRUE)){
					$this->getThread();	
				}
				else{
					$this->html = $this->view->getEditThreadTitlePage();
				}
			}
			else{
				$this->html = $this->view->getEditThreadTitlePage();	
			}	
		}
		else{
			$this->ifLoggedIn();
		}
	}//end of method
}