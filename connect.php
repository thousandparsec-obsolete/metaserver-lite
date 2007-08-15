<?php


require_once "class/GameConnect.php";
require_once "class/BackConnect.php";
//put this in different file !!!!
require_once "class/Frame.php";


$bc = new BackConnect('121.72.134.109', 6923);

$bc->connect();






?>