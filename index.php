<?php

require_once("src/controller/Mastercontroller.php");

session_start();

$masterController = new Mastercontroller();
$output = $masterController->startApplication();
echo "$output";
