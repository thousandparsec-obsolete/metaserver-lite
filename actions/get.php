<?php

  try
  {
    $now = time()-60 * 10;
     
     
    $r = $db->gamesNumber();
     
     
    $seq = new Frame(Frame::SEQUENCE, 1, array('no' => $r));
    print $seq->pack();
     
    $sql_details = "
      SELECT
      games.id, shortname, tp, server, sertype, rule, rulever,
      type, host, ip, port, locations.lastseen AS lastseen, ln
      FROM
      games
      JOIN
      locations ON games.id = locations.gid
      WHERE
      games.lastseen > ?
      ORDER BY
      games.id";
    $r = & $db->db->query($sql_details, array($now) );
     
    if (DB::isError ($r))
    {
      throw new Exception ("Error: " . $r->getMessage () . "\n");
    }
     
    //if (DB::isError($r))
    // die(new Frame(Frame::FAIL, 1, array('s' => print_r($r, 1))));
     
     
    $r->fetchInto($row, DB_FETCHMODE_ASSOC);
     
    while (true)
    {
      if (sizeof($row) == 0)
        break;
       
       
      $gid = $row['id'];
       
      $optional = array();
      $optional_index = array('', 'plys', 'cons', 'objs', 'admin', 'cmt', 'turn');
      foreach($db->db->getAssoc("SELECT `key`, value FROM optional WHERE gid=? AND lastseen > ?", false, array($gid, $now)) as $key => $value)
      {
        if (is_numeric($value))
          $optional[] = array(array_search($key, $optional_index), "", $value);
        else
          $optional[] = array(array_search($key, $optional_index), $value, 0);
      }
      $details = array(
      'sn' => $row['sn'],
        'key' => '',
        'tp' => explode(',', $row['tp']),
        'server' => $row['server'],
        'sertype' => $row['sertype'],
        'rule' => $row['rule'],
        'rulever' => $row['rulever'],
        'locations' => array(),
        'optional' => $optional,
        );
       
      // Get all the locations for this game
      $gid = $row['id'];
      do
      {
        if ($gid != $row['id'])
          break;
         
        $details['locations'][] = array($row['type'], $row['host'], $row['ip'], $row['port']);
         
        $lastseen = max($row['lastseen'], $lastseen);
      }
       while ($r->fetchInto($row, DB_FETCHMODE_ASSOC));
       
      //$game = new Frame(Frame::GAME, 1, $details);
      //print $game->pack();
      echo "Frame print disabled.<br />";
    }
    
  } catch (Exception $e) {
  
    $frame = new Frame(Frame::FAIL, 1, array('type'=>0, 'desc'=>$e->getMessage()));
    $pack = $frame->pack();
    echo $pack;
  }
?>