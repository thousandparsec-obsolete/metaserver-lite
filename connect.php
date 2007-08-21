<?php


require_once "class/GameConnect.php";
require_once "class/BackConnect.php";

//put this in different file !!!!
include("class/Frame.php");

//ciekawe czy to cholerstwo wezmie to jako zmienne lokalne :/ 

/**

connect to server, get all games, and check if data from GET table is same as data from server

*/
{

   
	$host = $locations[0]['host'];
	$port = $locations[0]['port'];
	
	
	
	
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
   
   $f_name = $bc->getFrame->get['name'];
   $f_key = $bc->getFrame->get['key'];
   $f_tp = $bc->getFrame->get['tp']; //array
   $f_server = $bc->getFrame->get['server'];
   $f_sertype = $bc->getFrame->get['sertype'];
   $f_rule = $bc->getFrame->get['rule'];
   $f_rulever = $bc->getFrame->get['rulever'];
   $f_locations = $bc->getFrame->get['locations']; //array
   $f_optional = $bc->getFrame->get['optional']; //array
   $f_URL = $bc->getFrame->get['URL'];
   
   if ($_REQUEST['name'] != $f_name || $_REQUEST['key'] != $f_key ||
			$_REQUEST['server'] != $f_server || $_REQUEST['sertype'] != f_sertype || 
			$_REQUEST['rule'] != $f_rule || $_REQUEST['rulever'] != $f_rulever )
	{
		die("wrong values");
	}
   
   //checking for tp
   if (array_search($_REQUEST['tp'], $f_tp) === NULL)
   	die("wrong values - tp");
   
   
   if (count($locations) != count($f_locations) )
   	die("wrong values - count locations");
   	
   foreach ($locations as $loc )
   {
   	foreach ($loc as $l)
   	{
   		if ($lo_ != "")
   			$tmp = 0;
   			foreach ($f_locations as $f_loc)
   			{
   				
   				if (array_search($lo_], $f_loc) !== NULL)
				   	$tmp = 1;
   			}
   			if ($tmp = 0)
   					die("wrong values - loc: ".$lo_);
   	}
   }
   
   
   
   $optional_ = array('plys' => 1 , 'cons' => 2 , 'objs' => 3 , 'admin' => 4, 'cmt' => 5 , 'turn' => 6 );
		
	foreach ($optional_ as $key => $value ) {
		if (array_key_exists($key, $_REQUEST))
		{
			$tmp = 0;
			 foreach ( $f_optional as $f_opt)
			 {
			 	$v = array_search($value, $f_opt)
			 	if ($v !== NULL)
			 	{
			 		$tmp = 1
			 		if (!($f_opt[1] == $_REQUEST['key'] || $f_opt[2] == $_REQUEST['key']  ))
			 			die("wrong values - opt.: ".$key);
			 	}
			 }
			 if ($tmp == 0)
				die("wrong values - opt: ".$key);
		}
	}
			
	
   
	   
	
}
	//getData($_GET['host'], $_GET['port'], $_GET['frame'],$_GET['mode'] );

	 

?>