<?php

	require_once "DB.php";
	require_once "class/Backend.php";



	/**

	inserting some test data

	*/

	$dsn = "mysqli://intart2_8:parsec@sql.intart2.nazwa.pl:3305/intart2_8";

	$time = time();

	$db = new Backend($dsn, $time);
	
	
	
	/*
  
	 	day statistics
	*/
	
/*
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '1', mktime( 0, 0, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '1', mktime( 0, 23, 43, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '2', mktime( 0, 45, 23, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '5', mktime( 1, 3, 4, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '10', mktime( 7, 5, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '11', mktime( 7, 56, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '5', mktime( 5, 0, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '2', mktime( 5, 0, 3, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '6', mktime( 5, 0, 5, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '20', mktime( 2, 0, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '6', mktime( 3, 0, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '4', mktime( 4, 0, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '7', mktime( 6, 0, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '9', mktime( 7, 0, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '3', mktime( 8, 0, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '18', mktime( 9, 0, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '12', mktime( 10, 0, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '10', mktime( 11, 0, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '17', mktime( 12, 0, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '1', mktime( 13, 0, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(5, 'objs', '18', mktime( 14, 34, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(5, 'objs', '12', mktime( 15, 36, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '1', mktime( 16, 23, 43, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '2', mktime( 17, 45, 23, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '5', mktime( 18, 3, 4, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '10', mktime( 19, 5, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '11', mktime( 20, 56, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '5', mktime( 21, 0, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '2', mktime( 22, 0, 3, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '6', mktime( 23, 0, 5, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '20', mktime( 2, 6, 5, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '6', mktime( 3, 8, 5, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '4', mktime( 4, 7, 5, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '7', mktime( 6, 33, 5, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '9', mktime( 7, 33, 5, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '3', mktime( 8, 33, 5, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '18', mktime( 9, 33, 5, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '12', mktime( 10, 33, 5, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '10', mktime( 11, 33, 5, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '17', mktime( 12, 33, 5, 7 ,  8 ,2007) ) );


		
	
	*/
	
	/*
		month
	*/

	/*
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '1', mktime( 0, 0, 0, 7 ,  1 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '1', mktime( 0, 23, 43, 7 ,  2 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '2', mktime( 0, 45, 23, 7 ,  3 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '5', mktime( 1, 3, 4, 7 ,  4 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '10', mktime( 2, 5, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '11', mktime( 7, 56, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '5', mktime( 5, 0, 0, 7 ,  7 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '2', mktime( 5, 0, 3, 7 ,  8 ,2007) ) ) ;
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '6', mktime( 5, 0, 5, 7 ,  9 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '20', mktime( 2, 0, 0, 7 ,  10 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '6', mktime( 3, 0, 0, 7 ,  11 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '4', mktime( 4, 0, 0, 7 ,  12 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '7', mktime( 6, 0, 0, 7 ,  1 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '9', mktime( 7, 0, 0, 7 ,  2 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '3', mktime( 8, 0, 0, 7 ,  3 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '18', mktime( 9, 0, 0, 7 ,  4 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '12', mktime( 11, 0, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '10', mktime( 11, 0, 0, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '17', mktime( 12, 0, 0, 7 ,  7 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '1', mktime( 13, 0, 0, 7 ,  8 ,2007) ) ) ;
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(5, 'objs', '18', mktime( 14, 34, 0, 7 ,  9 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(5, 'objs', '12', mktime( 15, 36, 0, 7 ,  10 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '1', mktime( 16, 23, 43, 7 ,  11 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '2', mktime( 17, 45, 23, 7 ,  12 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '5', mktime( 18, 3, 4, 7 ,  1 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '10', mktime( 19, 5, 0, 7 ,  2 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '11', mktime( 20, 56, 0, 7 ,  3 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '5', mktime( 21, 0, 0, 7 ,  4 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '2', mktime( 21, 0, 3, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '6', mktime( 23, 0, 5, 7 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '20', mktime( 2, 6, 5, 7 ,  7 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '6', mktime( 3, 8, 5, 7 ,  8 ,2007) ) ) ;
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '4', mktime( 4, 7, 5, 7 ,  9 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '7', mktime( 6, 33, 5, 7 ,  10 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '9', mktime( 7, 33, 5, 7 ,  11 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '3', mktime( 8, 33, 5, 7 ,  12 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '18', mktime( 9, 33, 5, 7 ,  1 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '12', mktime( 10, 33, 5, 7 ,  2 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '10', mktime( 11, 33, 5, 7 ,  3 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '17', mktime( 12, 33, 5, 7 ,  4 ,2007) ) );
  
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '1', mktime( 0, 0, 0, 7 ,  13 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '1', mktime( 0, 23, 43, 7 ,  14 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '2', mktime( 0, 45, 23, 7 ,  18 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '5', mktime( 1, 3, 4, 7 ,  18 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '10', mktime( 2, 5, 0, 7 ,  17 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '11', mktime( 7, 56, 0, 7 ,  18 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '5', mktime( 5, 0, 0, 7 ,  19 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '2', mktime( 5, 0, 3, 7 ,  20 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '6', mktime( 5, 0, 5, 7 ,  21 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '20', mktime( 2, 0, 0, 7 ,  22 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '6', mktime( 3, 0, 0, 7 ,  23 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '4', mktime( 4, 0, 0, 7 ,  24 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '7', mktime( 6, 0, 0, 7 ,  28 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '9', mktime( 7, 0, 0, 7 ,  28 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '3', mktime( 8, 0, 0, 7 ,  27 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '18', mktime( 9, 0, 0, 7 ,  28 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '12', mktime( 11, 0, 0, 7 ,  29 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '10', mktime( 11, 0, 0, 7 ,  30 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '17', mktime( 12, 0, 0, 7 ,  31 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '1', mktime( 13, 0, 0, 7 ,  13 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(5, 'objs', '18', mktime( 14, 34, 0, 7 ,  14 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(5, 'objs', '12', mktime( 15, 36, 0, 7 ,  18 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '1', mktime( 16, 23, 43, 7 ,  18 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '2', mktime( 17, 45, 23, 7 ,  17 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '5', mktime( 18, 3, 4, 7 ,  18 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '10', mktime( 19, 5, 0, 7 ,  19 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '11', mktime( 20, 56, 0, 7 ,  20 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '5', mktime( 21, 0, 0, 7 ,  21 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '2', mktime( 21, 0, 3, 7 ,  22 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '6', mktime( 23, 0, 5, 7 ,  23 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '20', mktime( 2, 6, 5, 7 ,  24 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '6', mktime( 3, 8, 5, 7 ,  28 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '4', mktime( 4, 7, 5, 7 ,  28 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '7', mktime( 6, 33, 5, 7 ,  27 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '9', mktime( 7, 33, 5, 7 ,  28 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '3', mktime( 8, 33, 5, 7 ,  29 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '18', mktime( 9, 33, 5, 7 ,  30 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '12', mktime( 10, 33, 5, 7 ,  31 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '10', mktime( 11, 33, 5, 7 ,  30 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '17', mktime( 12, 33, 5, 7 ,  29 ,2007) ) );
							
	
	
							
	*/			
						  
/**
	YEAR
*/
						  
						  /*	
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '1', mktime( 0, 0, 0, 1 ,  1 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '1', mktime( 0, 23, 43, 2 ,  2 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '2', mktime( 0, 45, 23, 3 ,  3 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '5', mktime( 1, 3, 4, 4 ,  4 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '10', mktime( 2, 5, 0, 5 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '11', mktime( 7, 56, 0, 6 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '5', mktime( 1, 0, 0, 7 ,  7 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '2', mktime( 5, 0, 3, 8 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '6', mktime( 5, 0, 5, 9 ,  9 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '20', mktime( 2, 0, 0, 10 ,  10 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '6', mktime( 3, 0, 0, 11 ,  11 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '4', mktime( 4, 0, 0, 12 ,  12 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '7', mktime( 6, 0, 0, 1 ,  1 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '9', mktime( 7, 0, 0, 2 ,  2 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '3', mktime( 8, 0, 0, 3 ,  3 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '18', mktime( 9, 0, 0, 4 ,  4 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '12', mktime( 11, 0, 0, 5 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '10', mktime( 11, 0, 0, 6 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '17', mktime( 12, 2, 2, 7 ,  7 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '1', mktime( 13, 0, 0, 8 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(5, 'objs', '18', mktime( 14, 34, 0, 9 ,  9 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(5, 'objs', '12', mktime( 15, 36, 0, 10 ,  10 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '1', mktime( 16, 23, 43, 11 ,  11 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '2', mktime( 17, 45, 23, 12 ,  12 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '5', mktime( 18, 3, 4, 1 ,  2 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '10', mktime( 19, 5, 0, 2 ,  3 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '11', mktime( 20, 56, 0, 3 , 4 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '5', mktime( 21, 0, 5, 4 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '2', mktime( 21, 0, 1, 5 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '6', mktime( 23, 0, 3, 6 ,  7 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '20', mktime( 2, 6, 2, 8 ,  8 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '6', mktime( 3, 8, 9, 9 ,  9 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '4', mktime( 4, 7, 8, 10 ,  10 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '7', mktime( 6, 33, 7, 11 ,  11 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '9', mktime( 7, 33, 6, 12 ,  12 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '3', mktime( 8, 33, 5, 1 ,  14 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '18', mktime( 9, 33, 4, 2 ,  1 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '12', mktime( 10, 33, 3, 3 ,  12 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '10', mktime( 11, 33, 2, 4 ,  13 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(3, 'objs', '17', mktime( 12, 33, 1, 5 ,  14 ,2007) ) );
  
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '1', mktime( 0, 0, 0, 6 ,  23 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '1', mktime( 0, 23, 41, 7 ,  24 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '2', mktime( 0, 45, 23, 8 ,  28 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '5', mktime( 1, 3, 4, 9 ,  28 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '10', mktime( 2, 5, 0, 10 ,  27 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(1, 'objs', '11', mktime( 7, 56, 0, 11 ,  28 ,2007) ) );
	$r = $db->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array(2, 'objs', '5', mktime( 5, 0, 0, 12 ,  29 , 2007) ) );
	*/
	
?>