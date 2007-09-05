<?php
   
  require_once "DB.php";
  require_once "class/Backend.php";
  require_once "config.php";
   
   
   
   
   
  $time = time();
  $db = new Backend($dsn, $time);
   
   
  switch ($_REQUEST['action'])
  {
    case 'update':
    include ("actions/update.php");
    break;
    case 'get':
    include ("actions/get.php");
    break;
    default:
    include ("actions/default.php");
    break;
  }

