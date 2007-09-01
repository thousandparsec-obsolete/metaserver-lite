<?php
   
  /**
  *
  * Class: Backend
  * responsible for gatering and inserting data
  * into database
  *
  */
   
  class Backend {
     
    /**
    @TODO change to private
    */
    public $db;
    private $now;
     
    public function __construct($dsn, $now)
    {
      $this->now = $now;
      $this->db = & DB::connect ($dsn);
       
      if (DB::isError ($this->db))
        {
        throw new Exception ("Cannot connect: " . $this->db->getMessage () . "\n");
      }
       
    }
     
    /**
    Return number of games having this same optional parameter
     
    @param key optional parameter key
    @return number of games
     
    */
    public function getOptionalServers($key)
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
       
      $r = $this->db->getAll($sql_optional_servers, array($now , $key) );
       
      if (DB::isError ($r))
        {
        throw new Exception ("get_optional_servers error: " . $r->getMessage () . "\n");
      }
      if (is_null($r[0][0]))
        $r[0][0] = 0;
       
      return $r;
    }
     
    /**
    * Substract a certain value from time - use this when you want to get values before
    * the time set in class constructor.
    *
    * @param value Number of secound you wanted to substract from time
    *
    */
    public function substractFromTime($value)
    {
      $this->now = $this->now - $value;
    }
     
     
    /** 
    
    get sum of for all games for given optional parameter
    
    @param optional key
    @return sum of for all games for given optional parameter
    */
    public function getOptional($key)
    {
      $sql_optional = "SELECT SUM( value )
        FROM optional
        JOIN games ON games.id = optional.gid
        AND games.lastseen = optional.update_time
        WHERE games.lastseen > ? AND optional.key = ?";
       
      $r = $this->db->getall($sql_optional, array($this->now , $key) );
       
       
      if (DB::isError ($r))
        {
        throw new Exception ("get_optional error: " . $r->getMessage () . "\n");
      }
       
      if (is_null($r[0][0]))
        $r[0][0] = 0;
       
      return $r;
    }

    /** 
    
    get all data from locations table
     
    @param gid game id
    @return all information for given game
    */
    public function gameDetails($gid)
    {
      $sql_details = "
        SELECT
        games.id, shortname, tp, server, sertype, rule, rulever,
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
        throw new Exception ("error: " . $r->getMessage () . "\n");
      }
       
      return $r;
       
    }
     
    /**
     get number of games currently avalible 
      
     @return Returns the number of games currently avalible
    */
    public function gamesNumber()
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
        throw new Exception ("game_number error: " . $r->getMessage () . "\n");
      }
       
      return $r[0][0];
    }
     
    /** 
    get game id for given shortname
    *
    * @param name - game shortname
    * @return game id
    */
    public function getId($name )
    {
      $r = $this->db->getall("SELECT `id` FROM games WHERE shortname = ?", array($name) );
       
      if (DB::isError ($r))
        {
        throw new Exception ("error: " . $r->getMessage () . "\n");
      }
      return $r[0][0];
       
    }
     
    /** 
    
    return key from games table for given shortname
    * @param shortname - game shortname
    * @return key from games table
    */
    public function getKey($shortname)
    {
       
      $result = $this->db->getall("SELECT `key` FROM games WHERE shortname = ?", array($shortname ));
      if (DB::isError ($result))
        {
        throw new Exception ("error: " . $result->getMessage () . "\n");
      }
      return $result;
    }
     
    /**
    insert into locations table
	
	@param  gid  - game id
	@param  type - type
	@param  host - host
	@param  ip - ip
	@param  port - port
	

    */
    public function replaceLocation($gid, $type, $host, $ip, $port)
    {
      $r = $this->db->query("REPLACE INTO locations (gid, `type`, host, ip, port, lastseen) VALUES (?, ?, ?, ?, ?, ?)",
        array($gid, $type, $host, $ip, $port, $this->now));
       
      if (DB::isError ($r))
        {
        throw new Exception ("error: " . $r->getMessage () . "\n");
      }
    }
     
    /**
    Insert into optional table
     
    @param gid    -game id
    @param option - option key name
    @param r_option - option key value
    */
    public function insertOptional($gid, $option, $r_option )
    {
      $r = $this->db->query("INSERT INTO optional (gid, `key`, value, update_time) VALUES (?, ?, ?, ?)",
        array($gid, $option, $r_option, $this->now) );
       
      if (DB::isError ($r))
        {
        throw new Exception ("insert optional error: " . $r->getMessage () . "\n");
      }
    }
     
    /**
    update Games table
	 @param  tp       - Supported protocol version
	 @param  server   - The version of the server
	 @param  sertype  - The name of the server software
	 @param  rule     - The name of the ruleset
	 @param  rulever  - The version of the ruleset
	 @param  sn       - short name for the game
	 @param  ln       - long name for the game

    */
    public function update($tp, $server, $sertype, $rule, $rulever, $sn, $ln)
    {
      $r = $this->db->query("UPDATE games SET lastseen=?, tp=?, server=?, sertype=?, rule=?, rulever=?, longname=? WHERE shortname=?", array(
      $this->now, $tp, $server, $sertype, $rule, $rulever, $ln, $sn));
      if (DB::isError ($r))
        {
        throw new Exception ("error: " . $r->getMessage () . "\n");
      }
    }
     
    /**
    insert into Games table

    @param  sn       - short name for the game
    @param  key      - The key for the game
	 @param  tp       - Supported protocol version
	 @param  server   - The version of the server
	 @param  sertype  - The name of the server software
	 @param  rule     - The name of the ruleset
	 @param  rulever  - The version of the ruleset
	 @param  ln       - long name for the game 

    */
    public function insert($sn, $key, $tp, $server, $sertype, $rule, $rulever, $ln)
    {
      $r = $this->db->query("INSERT INTO games (shortname, `key`, lastseen, tp, server, sertype, rule, rulever, firstseen, longname) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($sn, $key, $this->now, $tp, $server, $sertype, $rule, $rulever, $this->now , $ln));
      if (DB::isError ($r))
        {
        throw new Exception ("error: " . $r->getMessage () . "\n");
      }
    }
     
    /* 
    This function takes key, and dates.
    For all dates != 0 it return statistics for every hour
    For if day==0 it return statistic for all day in  month
    For month == 0 & day == 0 it returns statistics for every month (sum of all statistics)
     
    @param key   - key from optional talbe for which we want our statitics
    @param year  - year in XXXX format
    @param month - month
    @param day   - day
    @param type  - max, avg or nin - type of stats
    @param gid   - optional, game for whitch we want our statictics
    */
    public function getStatisticFromOptional ($key, $year, $month, $day, $type, $gid = false)
    {
      if ($type != 'avg' && $type != 'sum' && $type != 'max' && $type != 'min')
        throw new Exception("<br />wrong function parameters<br />");
      if ($gid !== false)
        {
        $add = " and gid = $gid";
        $add_end = ", gid";
      }
       
      if ($day != 0 && $month != 0 )
        {
        //Dayly statistics
         
        $time_from = mktime(0, 0, 0, $month, $day, $year);
        $time_to = mktime(23, 59 , 59, $month, $day, $year);
         
        $update_time = "update_time >= ".$time_from;
        $update_time .= " AND update_time <= ".$time_to;
        $update_time .= " AND YEAR(FROM_UNIXTIME(update_time))=".$year;
        $update_time .= " AND MONTH(FROM_UNIXTIME(update_time))=".$month;
        $update_time .= " AND DAY(FROM_UNIXTIME(update_time))=".$day;
        $group_by = " HOUR(FROM_UNIXTIME(update_time)) ";
         
         
      }
      else if ($day == 0 && $month != 0)
      {
        //monthly statistics
         
        $time_from = mktime(0, 0, 0, $month, 1, $year);
        $time_to = mktime(23, 59 , 59, $month + 1, 0, $year);
         
        $update_time = "update_time >= ".$time_from;
        $update_time .= " AND update_time <= ".$time_to;
        $update_time .= " AND YEAR(FROM_UNIXTIME(update_time))=".$year;
        $update_time .= " AND MONTH(FROM_UNIXTIME(update_time))=".$month;
        $group_by = " DAY(FROM_UNIXTIME(update_time)) ";
      }
      else if ($day == 0 && $month == 0)
      {
        //year statistics
         
        $time_from = mktime(0, 0, 0, 1, 1, $year);
        $time_to = mktime(23, 59 , 59, 12, 31, $year);
         
        $update_time = "update_time >= ".$time_from;
        $update_time .= " AND update_time <= ".$time_to;
        $update_time .= " AND YEAR(FROM_UNIXTIME(update_time))=".$year;
        $group_by = " MONTH(FROM_UNIXTIME(update_time)) ";
      }
      else throw new Exception("<br />wrong function parameters<br />");
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
       
      $r = $this->db->getAll($sql);
       
      if (DB::isError ($r))
      {
        throw new Exception ("error: " . $r->getMessage () . "\n");
      }

      return $r;
    }
  }