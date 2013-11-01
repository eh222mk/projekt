<?php

require_once("src/model/Thread.php");
require_once("src/model/Session.php");

class Database{
	/**
	 * @return mysqli_select_db
	 */
	private function connectToDatabase(){
		$connect = mysqli_connect("127.0.0.1","Erik","") or die("Couldn't connect!");
		mysqli_select_db($connect, "phpprojekt") or die("Couldn't find database");
		return $connect;
	}//end of method
	
	/**
	 * @param string username
	 * @return boolean
	 */
	public function userExist($username){
		$connect = $this->connectToDatabase();
		$query = mysqli_query($connect, "SELECT * FROM User WHERE Username='$username'");
		$numrows = mysqli_num_rows($query);
		if($numrows == 0){
			mysqli_close($connect);
			return false;
		}
		mysqli_close($connect);
		return true;
	}//end of method
	
	/**
	 * @param string thread
	 * @return boolean
	 */
	public function threadExist($thread){
		$connect = $this->connectToDatabase();
		$query = mysqli_query($connect, "SELECT * FROM Thread WHERE Title='$thread'");
		$numrows = mysqli_num_rows($query);
		if($numrows == 0){
			mysqli_close($connect);
			return false;
		}
		mysqli_close($connect);
		return true;
	}//end of method
	
	/**
	 * @param UserCredential userValues
	 */
	public function insertUserInDatabase(UserCredential $userValues){
		$connect = $this->connectToDatabase();
		$username = $userValues->getUsername();
		$password = $userValues->getPassword();
		$email = $userValues->getEmail();
		$query = "INSERT INTO User(Username,Password,Email) 
				  VALUES (\"" . $username . "\",\"" . $password . "\",\"" . $email . "\")";
			
		mysqli_query($connect, $query) or die("Query didn't work");
		mysqli_close($connect);
	}//end of method
	
	/**
	 * @param string username
	 * @param string password
	 * @return true
	 */
	public function ifLoginSuccess($username, $password){
		$connect = $this->connectToDatabase();
		$query = mysqli_query($connect, "SELECT * FROM User WHERE Username='$username'");
		$numrows = mysqli_num_rows($query);

		if ($numrows != 0){
			//get Username & password from database
			while($row = mysqli_fetch_assoc($query)){
				$dbusername = $row['Username'];
				$dbpassword = $row['Password'];	
			}//end of while
			
			//check so the username & password input is the same as in the database 
			if ($username==$dbusername&&$password==$dbpassword){
				mysqli_close($connect);
				return true;
			}
		}
		mysqli_close($connect);
		return false;
	}//end of method
	
	/**
	 * @param string username
	 * @return true
	 */
	public function ifUserAdmin($username){
		$connect = $this->connectToDatabase();
		$query = mysqli_query($connect, "SELECT * FROM User WHERE Username='$username'");
		$numrows = mysqli_num_rows($query);
		if($numrows != 0){
			//get Username & password from database
			while($row = mysqli_fetch_assoc($query)){
				$dbadmin = $row['Admin'];	
			}//end of while
			
			//check so the username & password input is the same as in the database 
			if($dbadmin == 1){
				mysqli_close($connect);
				return true;
			}
		}
		mysqli_close($connect);
		return false;
	}//end of method
	
	/**
	 * @param string title
	 * @param string content
	 * @param string user
	 */
	public function insertNewThreadInDatabase($title, $content, $user){
		$connect = $this->connectToDatabase();
		$query = "INSERT INTO thread(Title,Content,User) 
				  VALUES (\"" . $title . "\",\"" . $content . "\",\"" . $user . "\")";		
		mysqli_query($connect, $query) or die("Query didn't work");
		mysqli_close($connect);
	}//end of method
	
	/**
	 * @param string title
	 */
	public function deleteThreadFromDatabase($title){
		$connect = $this->connectToDatabase();
		$this->deleteCommentsOnThread($title);
		$query = "DELETE FROM thread WHERE Title ='$title'";
		$result = mysqli_query($connect, $query) or die("Kunde inte radera tråden.");
		$query = "DELETE FROM threadcomments WHERE Thread ='$title'";
		$result = mysqli_query($connect, $query);
		mysqli_close($connect);
	}//end of method
	
	/**
	 * @param string title
	 */
	private function deleteCommentsOnThread($title){
		$connect = $this->connectToDatabase();
		$query = "DELETE FROM threadcomments WHERE Thread ='$title'";
		$result = mysqli_query($connect, $query) or die("Kunde inte radera tråden.");
		mysqli_close($connect);
	}//end of method
	
	/**
	 * @param int id
	 * @param string value
	 */
	public function editCommentFromDatabase($id, $value){
		$connect = $this->connectToDatabase();
		$query = "UPDATE threadcomments SET Comment='$value' WHERE commentID ='$id'";
		$result = mysqli_query($connect, $query);
		mysqli_close($connect);
	}//end of method
	
	/**
	 * @param string user
	 * @param string thread
	 * @return boolean
	 */
	public function getIfUserPostedThread($user, $thread){
		$connect = $this->connectToDatabase();
		$query = "SELECT * FROM thread where Title = '$thread' AND User = '$user'";
		$result = mysqli_query($connect, $query);
		$row = mysqli_num_rows($result);
		if($row == 1){
			mysqli_close($connect);
			return true;
		}
		mysqli_close($connect);
		return false;
	}//end of method
	
	/**
	 * @param string thread
	 * @param string value
	 */
	public function editTitleFromDatabase($thread, $value){
		$connect = $this->connectToDatabase();
		$query = "UPDATE thread SET Content='$value' WHERE Title ='$thread'";
		$result = mysqli_query($connect, $query);
		mysqli_close($connect);
	}//end of method
	
	/**
	 * @param int commentID
	 * @return string
	 */
	public function getCommentContent($commentID){
		$connect = $this->connectToDatabase();
		$query = "SELECT Comment FROM threadcomments WHERE commentID='$commentID'";
		$result = mysqli_query($connect, $query) or die("Kunde inte hitta Kommentaren");
		$row = mysqli_fetch_row($result);
		mysqli_close($connect);
		return $row[0];
	}//end of method
	
	/**
	 * @param string thread
	 * @return string
	 */
	public function getTitleContent($thread){
		$connect = $this->connectToDatabase();
		$query = "SELECT Content FROM thread WHERE Title='$thread'";
		$result = mysqli_query($connect, $query) or die("Kunde inte hitta Tråden");
		$row = mysqli_fetch_row($result);
		mysqli_close($connect);
		return $row[0];
	}//end of method
	
	/**
	 * @param string user
	 * @param int id
	 * @return boolean
	 */
	public function getIfUserPostedComment($user, $id){
		$connect = $this->connectToDatabase();
		$query = "SELECT * FROM threadComments WHERE commentID='$id' AND User='$user'";
		$result = mysqli_query($connect, $query);
		$numrows = mysqli_num_rows($result);
		if($numrows == 1){
			mysqli_close($connect);
			return true;
		}
		mysqli_close($connect);
		return false;
	}//end of method
	
	/**
	 * @param int id
	 */
	public function deleteCommentFromDatabase($id){
		$connect = $this->connectToDatabase();
		$query = "DELETE FROM threadComments WHERE commentID ='$id'";
		$result = mysqli_query($connect, $query) or die("Kunde inte radera kommentaren.");
		mysqli_close($connect);
	}//end of method
	
	/**
	 * @param string title
	 * @return string
	 */
	public function getThreadContent($title){
		if(!$this->threadExist($title)){
			die("<html><header>
					<meta charset='utf8' /></header>
				Sluta försöka gå in på icke existerande trådar!!!</html>");
		}
		else{
			$connect = $this->connectToDatabase();
			$query = "SELECT * FROM thread WHERE Title ='$title'";
			$result = mysqli_query($connect, $query);	
			$row = mysqli_fetch_row($result);
			
			$thread = new thread();
			$thread->setTitle($title);
			$thread->setContent($row[2]);
			$thread->setUser($row[3]);
			mysqli_close($connect);
			return $thread;	
		}
	}//end of method
	
	/**
	 * @return array
	 */
	public function getThreads(){
		$connect = $this->connectToDatabase();
		$query = "SELECT * FROM thread ORDER BY ThreadID DESC";
		$result = mysqli_query($connect, $query);
		$counter = 0;
		while($row = mysqli_fetch_array($result)){
			$rows[$counter] = $row;
			$counter++;
		}
		mysqli_close($connect);
		return $rows;
	}//end of method
	
	/**
	 * @param string comment
	 * @param string thread
	 * @param string user
	 */
	public function insertNewComment($comment, $thread, $user){
		if(!$this->threadExist($thread)){
			die("<html><header>
					<meta charset='utf8' /></header>
				Den tråden existerar inte!</html>");
		}
		else{
			$connect = $this->connectToDatabase();
			$query = "INSERT INTO threadcomments(Thread,Comment,User) 
					  VALUES (\"" . $thread . "\",\"" . $comment . "\",\"" . $user . "\")";		
			mysqli_query($connect, $query) or die("Query didn't work");
			mysqli_close($connect);
		}
	}//end of method
	
	/**
	 * @param string thread
	 * @return array
	 */
	public function getComments($thread){
		$connect = $this->connectToDatabase();
		$query = "SELECT * FROM threadcomments WHERE Thread='$thread' ORDER BY commentID DESC";
		$result = mysqli_query($connect, $query);
		$counter = 0;
		$rows = null;
		while($row = mysqli_fetch_array($result)){
			$rows[$counter] = $row;
			$counter++;
		}
		mysqli_close($connect);
		return $rows;
	}//end of method
}
