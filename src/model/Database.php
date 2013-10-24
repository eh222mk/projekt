<?php

require_once("src/model/Threads.php");

class Database{
	
	private function connectToDatabase(){
		$connect = mysql_connect("127.0.0.1","Erik","") or die("Couldn't connect!");
		mysql_select_db("phpprojekt",$connect) or die("Couldn't find database");
	}//end of method
	
	public function insertUserInDatabase(UserCredential $userValues){
		$this->connectToDatabase();
		$username = $userValues->getUsername();
		$password = $userValues->getPassword();
		$email = $userValues->getEmail();
		$query = "INSERT INTO User(Username,Password,Email) 
				  VALUES (\"" . $username . "\",\"" . $password . "\",\"" . $email . "\")";
			
		mysql_query($query) or die("Query didn't work");
		mysql_close();
	}
	
	public function ifLoginSuccess($username, $password){
		$this->connectToDatabase();
		$query = mysql_query("SELECT * FROM User WHERE Username='$username'");
		$numrows = mysql_num_rows($query);

		if ($numrows != 0){
			//get Username & password from database
			while($row = mysql_fetch_assoc($query)){
				$dbusername = $row['Username'];
				$dbpassword = $row['Password'];	
			}//end of while
			
			//check so the username & password input is the same as in the database 
			if ($username==$dbusername&&$password==$dbpassword){
				$_SESSION["user"] = $username;
				return true;
			}
		}
		return false;
	}//end of method
	
	public function insertNewThreadInDatabase($title, $content, $user){
		$this->connectToDatabase();
		$time = time();
		$query = "INSERT INTO thread(Title,Content,User) 
				  VALUES (\"" . $title . "\",\"" . $content . "\",\"" . $user . "\")";		
		mysql_query($query) or die("Query didn't work");
		mysql_close();
	}
	
	public function getThreads(){
		$this->connectToDatabase();
		$query = "SELECT * FROM thread";
		$result = mysql_query($query);
		$counter = 0;
		while($row = mysql_fetch_array($result)){
			$rows[$counter] = $row;//mysql_fetch_array($result);
			$counter++;
		}
		
		mysql_close();
		return $rows;
	}
}
