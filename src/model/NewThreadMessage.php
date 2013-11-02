<?php 

require_once("src/enum/purplekiwienum.php");

class NewThreadMessage extends purplekiwienum{
	const EmptyInput = "<p>Inget av värderna får vara tomma!</p>";
	const ErrorTitleLength = "<p>Titeln måste vara mellan 5 och 50 tecken!</p>";
	const ErrorContentLength = "<p>innehållet får inte vara över 500 tecken!</p>";
	const SqlInjectionAttempt = "<p>SQL Injections är dåligt!!</p>";
	const ThreadExist = "<p>Tråden existerar redan.";
	const NewThreadSuccess = "<p>Lyckades skapa ny tråd.";
	const InvalidCaptcha = "<p>Felaktig Captcha!</p>";
}
