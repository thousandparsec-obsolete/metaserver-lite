<?php
	require_once "DB.php";
	require_once "class/Backend.php";
	require_once "class/Statistics.php";
	require_once "class/SwfCharts.php";

	
	
	$dsn = "mysqli://intart2_8:parsec@sql.intart2.nazwa.pl:3305/intart2_8";

	$time = time();

	$db = new Backend($dsn, $time);
	
	$time_array = getdate();
	
	$month = $_GET['month'];
	$day = $_GET['day'];
	$year = $_GET['year'];
	$type = $_GET['type'];
	$graph = $_GET['graph'];
	$agr = $_GET['agr'];
	$opt = $_GET['opt'];
	$gid = $_GET['gid'];
	
	
	if ($graph == "") 
		$graph = 1;
	if ($month == "") 
		$month = $time_array['mon'];
	if ($day == "")
		$day = $time_array['mday'];
	if ($year == "")
		$year = $time_array['year'];
	if ($type == "")
		$type = 1;
	/*
		1 - table
		2 - graph
	*/
	if ($graph == "")
		$graph = 1;
	if ($agr == "") 
		$agr = 'avg';
	if ($opt == "")
		$opt = 'plys';
	if ($gid == "")
		$gid = 0;
	
	
	
	if ($type == 1)
	{
		if ($gid == 0 )
			$r = $db->getStatisticFromOptional ($opt,  $year , $month, $day, $agr );
		else
			$r = $db->getStatisticFromOptional ($opt,  $year , $month, $day, $agr, $gid );
	}
	if ($type == 2)
	{
		if ($gid == 0 )
			$r = $db->getStatisticFromOptional ($opt,  $year , $month, 0, $agr );
		else
			$r = $db->getStatisticFromOptional ($opt,  $year , $month, 0, $agr , $gid);
	}
	if ($type == 3)
	{
		if ($gid == 0 )
			$r = $db->getStatisticFromOptional ($opt,  $year , 0, 0, $agr );
		else
			$r = $db->getStatisticFromOptional ($opt,  $year , $month, 0, $agr , $gid);
	}

	$stat = new Statistics($type, 1);
	$stat->read_data($r);
	$data = $stat->getData();
	
	
	SwfCharts::drawPlotChart($data, 2);
	
	 
?>