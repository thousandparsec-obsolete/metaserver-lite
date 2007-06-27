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


	public function __construct($dsn, $now) {	
		$this->now = $now;
		$this->db =& DB::connect ($dsn);
		if (DB::isError ($this->db)) {
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
      	optional.lastseen > ? AND optional.key = ?";

    $result = $this->db->getall($sql_optional_servers, array($now, $key) );
 if (DB::isError ($result)) {	
			 die ("Cannot connect: " . $r->getMessage () . "\n");
			}
   	if (is_null($result[0][0]))
			$result[0][0] = 0;

    return $result;
  }

  public function get_optional($key)
  {
    $sql_optional = "
      SELECT
      	SUM(value)
      FROM
      	optional
      WHERE
      	lastseen > ? AND `key` = ?";

    $r = $this->db->getall($sql_optional, array($key));

   
    if (DB::isError ($result)) {	
			 die ("Cannot connect: " . $r->getMessage () . "\n");
			}
    if (is_null($result[0][0]))
			$result[0][0] = 0;

    return $result;
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
      	locations.lastseen > ?
      ORDER BY
      	games.id";
	$r = $this->db->getall($sql_details, array($this->now));

		  	if (DB::isError ($r)) {	
			 die ("Cannot connect: " . $r->getMessage () . "\n");
			}

		  
		  return $r;

	}

  /*
	 * Returns the number of games currently avalible.
	 */
	public function games_number() {

		$sql_number = "
      SELECT
      	count(DISTINCT games.id)
      FROM
      	games
      JOIN
      	locations ON games.id = locations.gid
      WHERE
      	locations.lastseen > ?";

		  $r = $this->db->getall($sql_number, array($this->now));

		  	if (DB::isError ($r)) {	
			 die ("Cannot connect: " . $r->getMessage () . "\n");
			}

		  
		  return $r[0][0];


	}
	public function get_id( $name )
	{
			$r = $this->db->getall("SELECT `id` FROM games WHERE name = ?", array($name) );
			
				if (DB::isError ($r)) {	
			 die ("error: " . $r->getMessage () . "\n");
			}	
		return $r[0][0];
	
	}
	
	public function replace_location($gid, $type, $host, $addr,  $location)
	{
		$r = $this->db->query("REPLACE INTO locations (gid, `type`, host, ip, port, lastseen) VALUES (?, ?, ?, ?, ?, ?)",
							array($gid, $type, $host, $addr, $location, $this->now));
		
			if (DB::isError ($r)) {	
			 die ("error: " . $r->getMessage () . "\n");
			}	
		
		
	}
	
	public function get_key($param)
	{
	
		$result = $this->db->getall("SELECT `key` FROM games WHERE name = ?", array($param ));
		return $result;
	}
	
	public function update_games($time, $tp, $server, $sertype, $rule, $rulever, $name_param)
	{
		$r = $db->query("UPDATE games SET lastseen=?, tp=?, server=?, sertype=?, rule=?, rulever=? WHERE name=?", array(
							$time, $tp, $server, $sertype, $rule, $rulever, $name_param ) );
		if (DB::isError ($r)) {	
			 die ("Cannot connect: " . $r->getMessage () . "\n");
			}					
		return $r;
	
	}
	
	public function insert_games($name_param,	$key, $time, $tp, $server, $sertype, $rule, $rulever)
	{
		$r = $db->query("INSERT INTO games (name, `key`, lastseen, tp, server, sertype, rule, rulever) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", array(
							$name_param,	$key, $time, $tp, $server, $sertype, $rule, $rulever ));
			 if (DB::isError ($r)) {		
			 die ("Cannot connect: " . $r->getMessage () . "\n");
			}			
			return $r;
	}
	public function update($tp, $server, $sertype, $rule, $rulever, $name)
	{
		$r = $this->db->query("UPDATE games SET lastseen=?, tp=?, server=?, sertype=?, rule=?, rulever=? WHERE name=?", array(
							$this->now, $tp, $server, $sertype, $rule, $rulever, $name));
  		if (DB::isError ($r)) {		
			 die ("Cannot connect: " . $r->getMessage () . "\n");
			}			
	}
	
	public function insert($name,	$key, $tp, $server, $sertype, $rule,   $rulever)
	{
			$r = $this->db->query("INSERT INTO games (name, `key`, lastseen, tp, server, sertype, rule, rulever) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", array(
							$name,	$key,
							$this->now, 
						   $tp, $server, $sertype, $rule,   $rulever));
		if (DB::isError ($r)) {		
			 die ("Cannot connect: " . $r->getMessage () . "\n");
			}	
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
	        `lastseen` bigint(20) NOT NULL,
	        PRIMARY KEY  (`gid`,`key`)
	      ) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
	     
		
		");
	
	  if (DB::isError ($r)) {	
			 die ("error: " . $r->getMessage () . "\n");
			}
	
	}
	

}



?>