<?php

require_once "DB.php";
require_once "libtpproto-php/Frame.php";

$dsn = "mysqli://metaserver:meatereater@localhost/metaserver";

$db =& DB::connect ($dsn);
if (DB::isError ($db)) {
     die ("Cannot connect: " . $db->getMessage () . "\n");
}

$sql_number = "
SELECT
	count(DISTINCT games.id)
FROM
	games
JOIN
	locations ON games.id = locations.gid 
WHERE 
	locations.lastseen > ?";

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

$sql_optional = "
SELECT
	SUM(value)
FROM
	optional
WHERE
	lastseen > ? AND `key` = ?";
$sql_optional_servers = "
SELECT
	count(DISTINCT games.id)
FROM
	games
JOIN
	optional ON games.id = optional.gid 
WHERE 
	optional.lastseen > ? AND optional.key = ?";

$time = time();

switch ($_REQUEST['action']) {
	case 'update':
		// Check all the required properties exist in the request
		$required = array('name', 'tp', 'server', 'sertype', 'rule', 'rulever');
		foreach ($required as $r)
			if (!array_key_exists($r, $_REQUEST))
				die("Required key $r doesn't exist!");

		print "<pre>";
		var_dump($_REQUEST);
		print "</pre>";

		$result = $db->getall("SELECT `key` FROM games WHERE name = ?", array($_REQUEST['name']));
		if (sizeof($result) > 0) {
			if (strcmp($result[0][0], $_REQUEST['key']) !== 0)
				die ("Key was not valid...");

			// Update the required values
			$r = $db->query("UPDATE games SET lastseen=?, tp=?, server=?, sertype=?, rule=?, rulever=? WHERE name=?", array(
							$time, 
							$_REQUEST['tp'], 
							$_REQUEST['server'], $_REQUEST['sertype'], 
							$_REQUEST['rule'],   $_REQUEST['rulever'],
							$_REQUEST['name']));
		} else {
			$r = $db->query("INSERT INTO games (name, `key`, lastseen, tp, server, sertype, rule, rulever) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", array(
							$_REQUEST['name'],	$_REQUEST['key'],
							$time, 
							$_REQUEST['tp'], 
							$_REQUEST['server'], $_REQUEST['sertype'], 
							$_REQUEST['rule'],   $_REQUEST['rulever']));
		}
		if (DB::isError($r)) 
			die(print_r($r, 1));

		// Get the ID
		$result = $db->getall("SELECT `id` FROM games WHERE name = ?", array($_REQUEST['name']));
		$gid = $result[0][0];

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
			$r = $db->query("REPLACE INTO locations (gid, `type`, host, ip, port, lastseen) VALUES (?, ?, ?, ?, ?, ?)",
							array($gid, $type, $host, join($addr, '.'), $location['port'], $time));
			if (DB::isError($r)) 
				die(print_r($r, 1));
		}

		// Update the optional properties
		$optional = array('plys', 'cons', 'objs', 'admin', 'cmt', 'turn');
		foreach ($optional as $option) {
			if (!array_key_exists($option, $_REQUEST))
				continue;
			$r = $db->query("REPLACE INTO optional (gid, `key`, value, lastseen) VALUES (?, ?, ?, ?)",
							array($gid, $option, $_REQUEST[$option], $time));
		}

		break;

	case 'get':
		$now = time()-60*10;
		$r = $db->getall($sql_number, array($now));
		$seq = new Frame(Frame::SEQUENCE, 1, array('no' => $r[0][0]));
		print $seq->pack();

		$r = $db->query($sql_details, array($now));
		if (DB::isError($r)) 
			die(new Frame(Frame::FAIL, 1, array('s' => print_r($r, 1))));

		$r->fetchInto($row, DB_FETCHMODE_ASSOC);
		while (true) {
			if (sizeof($row) == 0)
				break;

			$gid = $row['id'];
			$details = array(
				'name'		=> $row['name'],
				'key'		=> '',
				'tp'		=> explode(',', $row['tp']),
				'server'	=> $row['server'],
				'sertype'	=> $row['sertype'],
				'rule'		=> $row['rule'],
				'rulever'	=> $row['rulever'],
				'locations'	=> array(),
				'optional'  => $db->getAssoc("SELECT `key`, value FROM optional WHERE gid=? AND lastseen > ?", false, array($gid, $now)),
			);

			// Get all the locations for this game
			$gid   = $row['id'];
			do {
				if ($gid != $row['id'])
					break;

				$details['locations'][] = array($row['type'], $row['host'], $row['ip'], $row['port']);

				$lastseen = max($row['lastseen'], $lastseen);
			} while ($r->fetchInto($row, DB_FETCHMODE_ASSOC));

			$game = new Frame(Frame::GAME, 1, $details);
			print $game->pack();
		}

		break;
	default:
		$title = "Metaserver Server Listing";
		include "bits/start_page.inc";

		$now = time()-60*10;

		// Get all the statistics
		$servers = $db->getall($sql_number, array($now));
		$optional = array('plys', 'cons', 'objs', 'admin', 'cmt', 'turn');

		$players = $db->getall($sql_optional, array($now, 'plys'));
		if (is_null($players[0][0]))
			$players[0][0] = 0;
		$players_servers = $db->getall($sql_optional_servers, array($now, 'plys'));
		$connect = $db->getall($sql_optional, array($now, 'cons'));
		if (is_null($connect[0][0]))
			$connect[0][0] = 0;
		$connect_servers = $db->getall($sql_optional_servers, array($now, 'cons'));
		$objects = $db->getall($sql_optional, array($now, 'objs'));
		if (is_null($objects[0][0]))
			$objects[0][0] = 0;
		$objects_servers = $db->getall($sql_optional_servers, array($now, 'objs'));
?>

<div id="right" style="width: 300px;">
<?php include "bits/start_section.inc"; ?> 
<div class="stats">
<table>
	<tr>
		<td><b>Servers Registered:</b></td>
		<td><?php echo $servers[0][0]; ?></td>
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
		<td><?php echo $objects[0][0]/$objects_servers[0][0];  ?></td>
	</tr>
</table>
</div>
<?php include "bits/end_section.inc"; ?> 
</div>

<?php
		print '<div id="left" style="margin: 0 310px 0 0;">';
	 
		if ($servers[0][0] == 0) {
			include "bits/start_section.inc";
			print "<p>No servers currently registered.</p>";
			include "bits/end_section.inc";
		} else {
			include "bits/start_section.inc";
			$r = $db->query($sql_details, array($now));
			if (DB::isError($r)) 
				die(print_r($r, 1));
			$r->fetchInto($row, DB_FETCHMODE_ASSOC);
			while (true) {
				if (sizeof($row) == 0)
					break;

				$gid   = $row['id'];

				// Get all the optional information
				$optional = $db->getAssoc("SELECT `key`, value FROM optional WHERE gid=? AND lastseen > ?", false, array($gid, $now));

				print "<h2>{$row['name']}</h2>\n";
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
