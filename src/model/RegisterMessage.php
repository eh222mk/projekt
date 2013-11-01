<?php

require_once("src/enum/purplekiwienum.php");

class RegisterMessage extends purplekiwienum{
	const NoUsername = "Var vänlig ange ett Användarnamn!";
	const NoPassword = "Var vänlig ange ett Lösenord!";
	const ErrorUsernameLength = "Felaktigt användarnamn! Måste vara mellan 4 och 20 tecken!";
	const ErrorPasswordLength = "Felaktigt Lösenord! Måste vara mellan 6 och 30 tecken!";
	const PasswordsNotSame = "Lösenorden stämmer inte överens! Var vänlig försök igen!";
	const ErrorEmail =  "Emailadressen är inte giltig!";
	const UserExist = "Den användaren finns redan!";
	const SqlInjection = "Sql injection är dåligt.";
}
