<?php

/**
 *
 * Class: Backend
 * responsible for gatering and inserting data
 * into database
 *
 */

/**
 * @TODO:
 *  - add some error handling functions
 *  - TEST it and insert into index.php
 *  - function comment
 *
 *
 */

class Backend {

	// in future: chenge tu private - now it;s public becouse of one query
  public $db;
  private $now;


	public function __construct($dsn, $now) 
	{	
		$this->now = $now;
		$this->db =& DB::connect ($dsn);
		
		if (DB::isError ($this->db)) 
		{
			 die ("Cannot connect: " . $this->db->getMessage () . "\n");
		}
		
	}


	/*

	 */
/*	public function games() {
		class games_iter {
			public function __construct($db) {
				$this->res =
			}

			public function fetchInto(&$row) {
			}
	}
*/
	public function get_optional_servers($key)
	{
	
		$sql_optional_servers = "
      SELECT
      	count(DISTINCT games.id)
      FROM
      	games
      JOIN
      	optional ON games.id = optional.gid
      WHERE
      	games.lastseen > ? AND optional.key = ?";

		$r = $this->db->getAll($sql_optional_servers, array($now  , $key) );
    
 		if (DB::isError ($r)) 
		{	
			die ("get_optional_servers error: " . $r->getMessage () . "\n");
		}	
   	if (is_null($r[0][0]))
			$r[0][0] = 0;

		return $r;
  }
	
  /**
  * substarct certain value from time - use this when you want to get values before 
  * set in class constructor
  * 
  * value: in secounds
  * 
  */	
  public function substract_from_time($value)
  {
  		$this->now = $this->now - $value;
  }
  
  
	/**
	@TODO: talk to mithro: could be there update to server more then 
	
	*/
  public function get_optional($key)
  {
	$sql_optional = "SELECT SUM( value )
				FROM optional
				JOIN games ON games.id = optional.gid
				AND games.lastseen = optional.update_time
      	WHERE games.lastseen > ? AND optional.key = ?";

    	$r = $this->db->getall($sql_optional, array($this->now , $key) );
		
   
    	if (DB::isError ($r)) 
		{	
			die ("get_optional error: " . $r->getMessage () . "\n");
		}	
		
    	if (is_null($r[0][0]))
			$r[0][0] = 0;

   	return $r;
	}

	public function game_details($gid)
	{
    $sql_details = "
      SELECT
      	games.id, name, tp, server, sertype, rule, rulever,
      	type, host, ip, port, locations.lastseen AS lastseen
      FROM
      	games
      JOIN
      	locations ON games.id = locations.gid
      WHERE
      	games.lastseen > ?
      ORDER BY
      	games.id";
      	
      	
		$r = $this->db->getall($sql_details, array($this->now));

		if (DB::isError ($r)) 
		{	
			die ("error: " . $r->getMessage () . "\n");
		}	

		
		  return $r;

	}

  /*
	 * Returns the number of games currently avalible.
	 */
	public function games_number() 
	{
		$sql_number = "SELECT count(DISTINCT games.id)
	      FROM
	         games
	      JOIN
	         locations ON games.id = locations.gid
	      WHERE
	         games.lastseen > ?";

		$r = $this->db->getall($sql_number, array($this->now ) );

		if (DB::isError ($r)) 
		{	
			die ("game_number error: " . $r->getMessage () . "\n");
		}	

		  
		return $r[0][0];
	}
	
	
	public function get_id( $name )
	{
		$r = $this->db->getall("SELECT `id` FROM games WHERE name = ?", array($name) );
			
		if (DB::isError ($r)) 
		{	
			 die ("error: " . $r->getMessage () . "\n");
		}	
		return $r[0][0];
	
	}
	
	public function get_key($param)
	{
	
		$result = $this->db->getall("SELECT `key` FROM games WHERE name = ?", array($param ));
		if (DB::isError ($result)) 
		{	
			 die ("error: " . $result->getMessage () . "\n");
		}	
		return $result;
	}
	
	public function replace_location($gid, $type, $host, $addr,  $location)
	{
		$r = $this->db->query("REPLACE INTO locations (gid, `type`, host, ip, port, lastseen) VALUES (?, ?, ?, ?, ?, ?)",
							array($gid, $type, $host, $addr, $location, $this->now));
		
		if (DB::isError ($r)) 
		{	
			 die ("error: " . $r->getMessage () . "\n");
		}	
		
		
	}
	
  /*
   this comment is to make sure I dont use update just insert - we want to insert new data every time 
   
  	public function replace_optional($gid, $option, $option )
	{
		$r = $this->db->query("REPLACE INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array($gid, $option, $option, $this->now) );
			
		if (DB::isError ($r)) 
		{	
			 die ("error: " . $r->getMessage () . "\n");
		}	
	}*/
	
	public function insert_optional($gid, $option, $r_option )
	{
		$r = $this->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
							array($gid, $option, $r_option, $this->now) );
			
		if (DB::isError ($r)) 
		{	
			 die ("insert optional error: " . $r->getMessage () . "\n");
		}	
		
	}
	
	
	public function update_games($time, $tp, $server, $sertype, $rule, $rulever, $name_param)
	{
		$r = $db->query("UPDATE games SET lastseen=?, tp=?, server=?, sertype=?, rule=?, rulever=? WHERE name=?", array(
							$time, $tp, $server, $sertype, $rule, $rulever, $name_param ) );
		if (DB::isError ($r)) 
		{	
			 die ("error: " . $r->getMessage () . "\n");
		}				
		return $r;
	
	}
	
	public function insert_games($name_param,	$key, $time, $tp, $server, $sertype, $rule, $rulever)
	{
		$r = $db->query("INSERT INTO games (name, `key`, lastseen, tp, server, sertype, rule, rulever) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", array(
							$name_param,	$key, $time, $tp, $server, $sertype, $rule, $rulever ));
		if (DB::isError ($r)) 
		{	
			 die ("error: " . $r->getMessage () . "\n");
		}			
		return $r;
	}
	
	
	public function update($tp, $server, $sertype, $rule, $rulever, $name)
	{
		$r = $this->db->query("UPDATE games SET lastseen=?, tp=?, server=?, sertype=?, rule=?, rulever=? WHERE name=?", array(
							$this->now, $tp, $server, $sertype, $rule, $rulever, $name));
  		if (DB::isError ($r)) 
		{	
			 die ("error: " . $r->getMessage () . "\n");
		}	
	}
	
	public function insert($name,	$key, $tp, $server, $sertype, $rule,   $rulever)
	{
		$r = $this->db->query("INSERT INTO games (name, `key`, lastseen, tp, server, sertype, rule, rulever) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", 									array($name, $key, $this->now, $tp, $server, $sertype, $rule,   $rulever));
		if (DB::isError ($r)) 
		{	
			 die ("error: " . $r->getMessage () . "\n");
		}	
	}
	
	/*
		this should be shorter but..
		this function takes key, and dates. 
		for all dates != 0 it return statistics for every hour 
		for if day==0 it return statistic for all day in  month
		for month == 0 & day == 0 it returns statistics for every month (sum of all statistics)
		
	*/
	public function getStatisticFromOptional ($key,  $year, $month, $day, $type, $gid = false)
	{
		if ($type != 'avg' && $type != 'sum' && $type != 'max' && $type != 'min')
			die("<br />wrong function parameters<br />");
		if ($gid !== false)
		{
			$add = " and gid = $gid";
			$add_end = ", gid";
		}

		if ($day != 0 && $month != 0 )
		{
			//Dayly statistics
			
			$time_from = mktime( 0, 0, 0, $month, $day, $year);
			$time_to = mktime( 23, 59 , 59, $month, $day, $year);
			
			$update_time = "update_time >= ".$time_from;
			$update_time .= " AND update_time <= ".$time_to;
			$update_time .= " AND YEAR(FROM_UNIXTIME(update_time))=".$year;
			$update_time .= " AND MONTH(FROM_UNIXTIME(update_time))=".$month;
			$update_time .= " AND DAY(FROM_UNIXTIME(update_time))=".$day;
			$group_by = " HOUR(FROM_UNIXTIME(update_time)) ";

			
		}
		else if ($day == 0 && $month !=0)
		{
			//monthly statistics
			
			$time_from = mktime( 0, 0, 0, $month, 1, $year);
			$time_to = mktime( 23, 59 , 59, $month + 1, 0, $year);
			
			$update_time = "update_time >= ".$time_from;
			$update_time .= " AND update_time <= ".$time_to;
			$update_time .= " AND YEAR(FROM_UNIXTIME(update_time))=".$year;
			$update_time .= " AND MONTH(FROM_UNIXTIME(update_time))=".$month;
			$group_by = " DAY(FROM_UNIXTIME(update_time)) ";
			
		
		}
		else if ($day == 0 &&  $month  == 0)
		{
			//year statistics
			
			$time_from = mktime( 0, 0, 0,   1,   1, $year);
			$time_to = mktime( 23, 59 , 59, 12, 31, $year);
			
			$update_time = "update_time >= ".$time_from;
			$update_time .= " AND update_time <= ".$time_to;
			$update_time .= " AND YEAR(FROM_UNIXTIME(update_time))=".$year;
			$group_by = " MONTH(FROM_UNIXTIME(update_time)) ";
			
		}
		else die("<br />wrong function parameters<br />");
		/*{
			$divide = 1;
			$update_time = " 1 = 1";
			$mod = 31;
			$divide = 60*60*24;
		}
		*/
		if ($type == 'avg')
			$type = "round(".$type."(CONVERT(value,UNSIGNED))) ";
		else $type = $type."(CONVERT(value,UNSIGNED)) ";
		
		
		$sql = "
			SELECT  ".$group_by.", ".$type." 
			FROM optional
			WHERE ".$update_time." AND `key` = '".$key."' ".$add." 		
			GROUP BY  ".$group_by." ".$add_end." 
			ORDER BY update_time  ";

		 //	echo $sql;
		
			

		$r = $this->db->getAll($sql);
		
		
		
		if (DB::isError ($r)) 
		{	
			 die ("error: " . $r->getMessage () . "\n");
		}			
		return $r;
	
	}
	
	
	public function create_database()
	{	
		$r = $this->db->query("


DROP TABLE IF EXISTS `games`;
CREATE TABLE `games` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `key` tinyblob NOT NULL,
  `lastseen` bigint(20) NOT NULL,
  `tp` tinyblob NOT NULL,
  `server` tinyblob NOT NULL,
  `sertype` tinyblob NOT NULL,
  `rule` tinyblob NOT NULL,
  `rulever` tinyblob NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `locations`;
CREATE TABLE `locations` (
  `id` bigint(20) NOT NULL auto_increment,
  `gid` bigint(20) NOT NULL,
  `type` varchar(10) NOT NULL,
  `host` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `port` int(11) NOT NULL,
  `lastseen` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `location` (`gid`,`type`,`ip`,`port`)
) ENGINE=MyISAM AUTO_INCREMENT=426 DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `optional`;
CREATE TABLE `optional` (
  `gid` bigint(20) NOT NULL,
  `key` varchar(10) NOT NULL,
  `value` varchar(255) NOT NULL,
  `update_time` bigint(20) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
		
		");
	
	  if (DB::isError ($r)) 
		{	
			 die ("error: " . $r->getMessage () . "\n");
		}	
	
	}
	

}



?>