<?php

  try 
  {
    $title = "Metaserver Server Listing";
    include "bits/start_page.inc";
     
    $db->substractFromTime(60 * 10);
     
     
    // Get all the statistics
    $servers = $db->gamesNumber();
     
    $optional = array('plys', 'cons', 'objs', 'admin', 'cmt', 'turn');
     
    $players = $db->getOptional('plys');
     
    if (is_null($players[0][0]))
      $players[0][0] = 0;
     
    $players_servers = $db->getOptionalServers('plys');
     
     
    $connect = $db->getOptional('cons');
     
    if (is_null($connect[0][0]))
      $connect[0][0] = 0;
    $connect_servers = $db->getOptionalServers('cons');
     
     
    $objects = $db->getOptional('objs');
     
     
    if (is_null($objects[0][0]))
      $objects[0][0] = 0;
    $objects_servers = $db->getOptionalServers('objs');
  ?>

<div id="right" style="width: 300px;">
<?php include "bits/start_section.inc"; ?> 
<div class="stats">
<table>
	<tr>
		<td><b>Servers Registered:</b></td>
		<td><?php echo $servers; ?></td>
	</tr>
	<tr>
		<td><b>Clients Connected:</b></td>
		<td><?php echo "{$connect[0][0]} on {$connect_servers[0][0]} servers";  ?></td>
	</tr>
	<tr>
		<td><b>Players Playing:</b></td>
		<td><?php echo "{$players[0][0]} on {$players_servers[0][0]} servers";  ?></td>
	</tr>
	<tr>
		<td><b>Objects Existing:</b></td>
		<td><?php echo "{$objects[0][0]} on {$objects_servers[0][0]} servers";  ?></td>
	</tr>
	<tr>
		<td><b>~Objects Per Server:</b></td>
		<td><?php if ($objects_servers[0][0] > 0) echo $objects[0][0]/$objects_servers[0][0];  ?></td>
	</tr>
</table>
<br /><br /><a href="stat.php">more statistics...</a><br />
</div>
<?php include "bits/end_section.inc"; ?> 
</div>

  <?php
    print '<div id="left" style="margin: 0 310px 0 0;">';
     
    if ($servers == 0)
    {
      include "bits/start_section.inc";
      print "<p>No servers currently registered.</p>";
      include "bits/end_section.inc";
    }
    else
    {
      include "bits/start_section.inc";
       
      // @TODO: it should be in function !!!
      $sql_details = "
        SELECT
        games.id, shortname, tp, server, sertype, rule, rulever,
        type, host, ip, port, locations.lastseen AS lastseen, longname
        FROM
        games
        JOIN
        locations ON games.id = locations.gid
        WHERE
        locations.lastseen > ?
        ORDER BY
        games.id";
       
       
      $r = $db->db->query($sql_details, array($time-60 * 10));
       
      if (DB::isError ($r))
      {
        die ("Error: " . $r->getMessage () . "\n");
      }
       
      $r->fetchInto($row, DB_FETCHMODE_ASSOC);
      while (true)
      {
        if (sizeof($row) == 0)
          break;
         
        $gid = $row['id'];
         
        // Get all the optional information
        $optional = $db->db->getAssoc("
          SELECT optional.key, optional.value
          FROM optional
          JOIN games ON games.id = optional.gid
          AND games.lastseen = optional.update_time
          WHERE optional.gid=? AND games.lastseen > ?", false, array($gid, $now));
         
        if (DB::isError ($optional))
          {
          die ("error: " . $optional->getMessage () . "\n");
        }
        if ($row['shortname']!="")
          print "<h2>{$row['longname']} ({$row['shortname']})</h2>\n"; 
        else
          print "<h2>{$row['shortname']}</h2>\n";
        print "<p>Running on {$row['sertype']} (Version: {$row['server']}) playing {$row['rule']} (Version: {$row['rulever']}) - {$optional['cmt']}</p>\n";
         
        //$optional = array('plys', 'cons', 'objs', 'admin', 'cmt', 'turn');
         
        print "<p>";
        if (array_key_exists('turn', $optional))
        {
          $date = gmdate("H:i:s, M d Y", $optional['turn']);
          $away = $optional['turn']-time();
           
          if ($away < 0)
            $away = "now";
          print "The next turn will be generated at $date (UTC) which is ~$away seconds away. ";
        }
         
        if (array_key_exists('cons', $optional))
          print "There are currently {$optional['cons']} clients connected. ";
        if (array_key_exists('plys', $optional))
          print "The game has currently {$optional['plys']} players. ";
        if (array_key_exists('objs', $optional))
          print "The Universe currently has {$optional['objs']} objects. ";
        if (array_key_exists('admin', $optional))
        {
          // FIXME: Should obscure the email somehow...
          $email = $optional['admin'];
          print "The admin contact for this server is <a href='mailto:$email'>$email</a>.";
        }
        print "</p>";
         
        // Get all the locations for this game
        print "<p>Can be connected to via:\n</p><ul>\n";
         
        $names = array(
          'tp' => 'Standard Connection',
          'tps' => 'Secure Connection',
          'tphttp' => 'HTTP Tunnel Connection',
          'tphttps' => 'Secure HTTP Tunnel Connection',
          );
         
        do
        {
          if ($gid != $row['id'])
            break;
          print "<li>";
          print "<a href='{$row['type']}://{$row['host']}:{$row['port']}/".urlencode("{$row['shortname']}")."'>";
          print $names[$row {
            'type' }
          ]." to ";
          print "{$row['host']} ({$row['ip']}:{$row['port']})";
          print "</a></li>\n";
        }
         while ($r->fetchInto($row, DB_FETCHMODE_ASSOC));
        print "</ul>";
      }
       
      include "bits/end_section.inc";
    }
     
     
    print "</div>";
    include "bits/end_page.inc";

  } catch (Exception $e) {
	// FIXME: Should probably do more then just print this message...
    echo $e->getMessage();
  }
