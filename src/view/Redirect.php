<?php
class Redirect{
	/**
	 * redirects to main 
	 */
	public function backToMain(){
		header("location: /php/projekt");
	}
	
	/**
	 * redirect back to the last read thread
	 */
	public function backToThread($thread){
		header("location: ?action=readthread&thread=".$thread."");
	}
}