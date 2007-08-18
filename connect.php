<?php


require_once "class/GameConnect.php";
require_once "class/BackConnect.php";

//put this in different file !!!!
include("class/Frame.php");


function getData($host, $port, $quiet=0 )
{
	($host != '' && $port != '' ) or die ('wrong parameters');
		
	try 
	{
		$bc = new BackConnect('203.122.246.117', 6923);

	   $bc->connect();
	   $bc->get_games();
	   $bc->disconnect();
	} catch (Exception $e) 
	{
		$bc->disconnect();
	   echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
	if ($mode == 0)
	{
		//write frame
		$bc->writeFrame();
	}
}

getData($_GET['host'], $_GET['port'], $_REQUIRE['quiet'] );


?>