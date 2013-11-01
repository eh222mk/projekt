<?php

require_once("src/recaptcha/recaptchalib.php");

class CaptchaModel{

	/**
	 * @notice! Ej skrivit metoden under själv, nycklarna har jag fått från google.
	 */
	private static $privateKey = "6LcNb-ASAAAAAJi_p19zlSIVK1lrXpUqAgd3X1-z";
	const PublicKey = "6LcNb-ASAAAAAEH5-TIB57bmJmXxT4Fm_avQHOlk";
	
	public function checkCaptcha(){
		$resp = recaptcha_check_answer (self::$privateKey,
									$_SERVER["REMOTE_ADDR"],
									$_POST["recaptcha_challenge_field"], //gör undantag för $_POST i det här fallet eftersom
									$_POST["recaptcha_response_field"]); //jag inte skrivit koden själv
		
		if(!$resp->is_valid) {
			return false;
		}
		return true;
	}
}