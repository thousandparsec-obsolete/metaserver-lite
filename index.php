<?php
   
  /*
  test
  */
   
  require_once "DB.php";
  require_once "class/Backend.php";
   
  //require_once "libtpproto-php/Frame.php";
   
   
   
  //$dsn = "mysqli://metaserver:meatereater@localhost/metaserver";
   
  //
  $dsn = "mysqli://intart2_8:parsec@sql.intart2.nazwa.pl:3305/intart2_8";
   
  $time = time();
   
  $db = new Backend($dsn, $time);
   
   
  // to consider: change switch for some kind of class/function responsible for all action
   
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