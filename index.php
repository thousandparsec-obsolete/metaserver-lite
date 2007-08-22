<?php

/*
test
*/

require_once "DB.php";
require_once "class/Backend.php";

//require_once "libtpproto-php/Frame.php";



//$dsn = "mysqli://metaserver:meatereater@localhost/metaserver";

//
$dsn = "mysqli://intart2_8:parsec@sql.intart2.nazwa.pl:3305/intart2_8";

$time = time();

$db = new Backend($dsn, $time);


// to consider: change switch for some kind of class/function responsible for all action

switch ($_REQUEST['action']) {
	case 'update':
		// Check all the required properties exist in the request
		
		
		$required = array('sn', 'tp', 'server', 'sertype', 'rule', 'rulever');
		foreach ($required as $r)
			if (!array_key_exists($r, $_REQUEST))
				die("Required key $r doesn't exist!");
		//include ("connect.php?")
		print "<pre>";
		var_dump($_REQUEST);
		print "</pre>";
		
		
		// Find the location details
		$location_values = array('type', 'dns', 'ip', 'port');
		$locations = array();
		while (1) {
			$i = count($locations);

			$location = array();
			foreach ($location_values as $k) {
				if (!array_key_exists($k.$i, $_REQUEST))
					die ("Could not find $k$i");
				$location[$k] = $_REQUEST[$k.$i];
			}
			$locations[] = $location;

			if (!array_key_exists("type".count($locations), $_REQUEST))
				break;
		}

		
		include("connect_.php");
		
		
		
		
		
		$result = $db->getKey( $_REQUEST['sn'] );
		if (sizeof($result) > 0) {
			if (strcmp($result[0][0], $_REQUEST['key']) !== 0)
				die ("Key was not valid...");

			// Update the required values
			$r = $db->update($_REQUEST['tp'], 
							$_REQUEST['server'], $_REQUEST['sertype'], 
							$_REQUEST['rule'],   $_REQUEST['rulever'],
							$_REQUEST['sn'], $_REQUEST['ln'], );
		} else {
			$r = $db->insert(
							$_REQUEST['sn'],	$_REQUEST['key'], 
							$_REQUEST['tp'], 
							$_REQUEST['server'], $_REQUEST['sertype'], 
							$_REQUEST['rule'],   $_REQUEST['rulever'], $_REQUEST['ln'], );
		}
		
		
		
		if (DB::isError($r)) 
			die(print_r($r, 1));

		// Get the ID
		$gid = $db->getId( $_REQUEST['sn'] );
	
		

		 
		
		
		
		
		// Validate the location stuff
		foreach ($locations as $location) {
			// Validate/format the data
			$valid_types = array('tp', 'tps', 'tphttp', 'tphttps');

			$type = $location['type'];
			if (!in_array($type, $valid_types))
				die("Type $type was not valid");

			$addr = explode('.', $location['ip']);
			// Check that the ip address is valid
			if (sizeof($addr) != 4)
				die("address wasn't a valid ip address");
			foreach($addr as $bit)
				if (!is_numeric($bit) || $bit < 0 || $bit > 255)
					die("address wasn't a valid ip address");
			// Check that the ip address is not a private address
			$private_addr = array('192', '10', '127', '172', '224');
			if (in_array($addr[0], $private_addr))
				die("address was private...");

			// Check the hostname is resolvable and goes to the same ip address
			$host = $location['dns'];
			$ip = gethostbyname($host);
			if (strcmp($ip, $host) === 0)
				die("unable to resolve the host address");

			$port = $location['port'];
			if (!is_numeric($port))
				die("port wasn't numeric!");

			if (strcmp(join($addr, '.'), $ip) !== 0)
				die("host name didn't resolve to ip $ip address given"); 

			// Add or update this location
			
			
			$r = $db->replaceLocation($gid, $type, $host, join($addr, '.'), $location['port'] );
			
		}

		// Update the optional properties
		$optional = array('plys', 'cons', 'objs', 'admin', 'cmt', 'turn');
		
		foreach ($optional as $option) {
			if (!array_key_exists($option, $_REQUEST))
			{
				continue;
			}

			$db->insertOptional($gid, $option, $_REQUEST[$option] );
			
		}

		break;

	case 'get':
		$now = time()-60*10;
		
		
		$r = $db->gamesNumber();
		
		
		//$seq = new Frame(Frame::SEQUENCE, 1, array('no' => $r));
		//print $seq->pack();
		$sql_details = "
      SELECT
      	games.id, sn, tp, server, sertype, rule, rulever,
      	type, host, ip, port, locations.lastseen AS lastseen, ln
      FROM
      	games
      JOIN
      	locations ON games.id = locations.gid
      WHERE
      	games.lastseen > ?
      ORDER BY
      	games.id";
		$r =& $db->db->query( $sql_details, array($now) );
	
			if (DB::isError ($r)) {	
			 die ("Error: " . $r->getMessage () . "\n");
			}
	
		//if (DB::isError($r)) 
		//	die(new Frame(Frame::FAIL, 1, array('s' => print_r($r, 1))));

		
		$r->fetchInto($row, DB_FETCHMODE_ASSOC);
		while (true) {
			if (sizeof($row) == 0)
				break;


			$gid = $row['id'];

			$optional = array();
			$optional_index = array('', 'plys', 'cons', 'objs', 'admin', 'cmt', 'turn');
			foreach($db->db->getAssoc("SELECT `key`, value FROM optional WHERE gid=? AND lastseen > ?", false, array($gid, $now)) as $key => $value) {
				if (is_numeric($value))
					$optional[] = array(array_search($key, $optional_index), "", $value);
				else
					$optional[] = array(array_search($key, $optional_index), $value, 0);
			}
			$details = array(
				'sn'		=> $row['sn'],
				'key'		=> '',
				'tp'		=> explode(',', $row['tp']),
				'server'	=> $row['server'],
				'sertype'	=> $row['sertype'],
				'rule'		=> $row['rule'],
				'rulever'	=> $row['rulever'],
				'locations'	=> array(),
				'optional'  => $optional,
			);

			// Get all the locations for this game
			$gid   = $row['id'];
			do {
				if ($gid != $row['id'])
					break;

				$details['locations'][] = array($row['type'], $row['host'], $row['ip'], $row['port']);

				$lastseen = max($row['lastseen'], $lastseen);
			} while ($r->fetchInto($row, DB_FETCHMODE_ASSOC));

			//$game = new Frame(Frame::GAME, 1, $details);
			//print $game->pack();
			echo "Frame print disabled.<br />";
		}

		break;
	default:
		$title = "Metaserver Server Listing";
		include "bits/start_page.inc";
		
		$db->substractFromTime(60*10);


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
	 
		if ($servers == 0) {
			include "bits/start_section.inc";
			print "<p>No servers currently registered.</p>";
			include "bits/end_section.inc";
		} else {
			include "bits/start_section.inc";
			
			// @TODO: it should be in function !!!
			$sql_details = "
      SELECT
      	games.id, sn, tp, server, sertype, rule, rulever,
      	type, host, ip, port, locations.lastseen AS lastseen, ln
      FROM
      	games
      JOIN
      	locations ON games.id = locations.gid
      WHERE
      	locations.lastseen > ?
      ORDER BY
      	games.id";
      	
      	
			$r = $db->db->query($sql_details, array($time-60*10));
			
			if (DB::isError($r)) 
				die(print_r($r, 1));
			$r->fetchInto($row, DB_FETCHMODE_ASSOC);
			while (true) {
				if (sizeof($row) == 0)
					break;

				$gid   = $row['id'];

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
				
				print "<h2>{$row['sn']}</h2>\n";
				print "<p>Running on {$row['sertype']} (Version: {$row['server']}) playing {$row['rule']} (Version: {$row['rulever']}) - {$optional['cmt']}</p>\n";

				//$optional = array('plys', 'cons', 'objs', 'admin', 'cmt', 'turn');

				print "<p>";
				if (array_key_exists('turn', $optional)) {
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
				if (array_key_exists('admin', $optional)) {
					// FIXME: Should obscure the email somehow...
					$email = $optional['admin'];
					print "The admin contact for this server is <a href='mailto:$email'>$email</a>.";
				}
				print "</p>";

				// Get all the locations for this game
				print "<p>Can be connected to via:\n<ul>\n";

				$names = array(
					'tp' 		=> 'Standard Connection',
					'tps'		=> 'Secure Connection',
					'tphttp'	=> 'HTTP Tunnel Connection',
					'tphttps'	=> 'Secure HTTP Tunnel Connection',
				);

				do {
					if ($gid != $row['id'])
						break;
					print "<li>";
					print "<a href='{$row['type']}://{$row['host']}:{$row['port']}/".urlencode("{$row['name']}")."'>";
					print $names[$row{'type'}]." to ";
					print "{$row['host']} ({$row['ip']}:{$row['port']})";
					print "</a></li>\n";
				} while ($r->fetchInto($row, DB_FETCHMODE_ASSOC));
				print "</ul></p>";
			}
		
			include "bits/end_section.inc";
		}
		
			
		print "</div>";
		include "bits/end_page.inc";
		break;
}