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


  private $db;
  private $now;


	public function __construct($dsn, $now) {
		$db =& DB::connect ($dsn);
		if (DB::isError ($db)) {
			 die ("Cannot connect: " . $db->getMessage () . "\n");
		}

		$this->db  = $db;
		$this->now = $now;
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

    $result = $db->getall($sql_optional_servers, array($now, $key) );

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

   $r = $db->getall($sql_optional, array($key));

   	$result = $db->getall($sql_optional, array($now, $key) );

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

		  $r = $db->getall($sql_number, array($now));

		  return $r[0][0];


	}
	
	public function get_key($param)
	{
		$result = $db->getall("SELECT `key` FROM games WHERE name = ?", array($param $_REQUEST[$name_param]));
		return $result;
	}
	
	public function update_games($time, $tp, $server, $sertype, $rule, $rulever, $name_param)
	{
		$r = $db->query("UPDATE games SET lastseen=?, tp=?, server=?, sertype=?, rule=?, rulever=? WHERE name=?", array(
							$time, $tp, $server, $sertype, $rule, $rulever, $name_param ) );
							
		return $r
	
	}
	
	public function insert_games($name_param,	$key, $time, $tp, $server, $sertype, $rule, $rulever)
	{
		$r = $db->query("INSERT INTO games (name, `key`, lastseen, tp, server, sertype, rule, rulever) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", array(
							$name_param,	$key, $time, $tp, $server, $sertype, $rule, $rulever ));
							
			return $r;
	}
	
	
	
	

}



?>