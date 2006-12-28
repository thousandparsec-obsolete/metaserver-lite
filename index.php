<?php

require_once "DB.php";
require_once "libtpproto-php/Frame.php";

$dsn = "mysqli://metaserver:meatereater@localhost/metaserver";

$db =& DB::connect ($dsn);
if (DB::isError ($db)) {
     die ("Cannot connect: " . $conn->getMessage () . "\n");
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

switch ($_REQUEST['action']) {
	case 'update':
		// Check all the required properties exist in the request
		$required = array('name', 'tp', 'server', 'sertype', 'rule', 'rulever');
		foreach ($required as $r)
			if (!array_key_exists($r, $_REQUEST))
				die("Required key $r doesn't exist!");

		$result = $db->getall("SELECT `key` FROM games WHERE name = ?", array($_REQUEST['name']));
		var_dump($result);
		if (sizeof($result) > 0) {
			if (strcmp($result[0][0], $_REQUEST['key']) !== 0)
				die ("Key was not valid...");

			// Update the required values
			$r = $db->query("UPDATE games SET lastseen=?, tp=?, server=?, sertype=?, rule=?, rulever=? WHERE name=?", array(
							time(), 
							$_REQUEST['tp'], 
							$_REQUEST['server'], $_REQUEST['sertype'], 
							$_REQUEST['rule'],   $_REQUEST['rulever'],
							$_REQUEST['name']));
		} else {
			$r = $db->query("INSERT INTO games (name, `key`, lastseen, tp, server, sertype, rule, rulever) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", array(
							$_REQUEST['name'],	$_REQUEST['key'],
							time(), 
							$_REQUEST['tp'], 
							$_REQUEST['server'], $_REQUEST['sertype'], 
							$_REQUEST['rule'],   $_REQUEST['rulever']));
		}
		if (DB::isError($r)) 
			die(print_r($r, 1));

		// Get the ID
		$result = $db->getall("SELECT `id` FROM games WHERE name = ?", array($_REQUEST['name']));
		print_r($result);
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
							array($gid, $type, $host, join($addr, '.'), $location['port'], time()));
			if (DB::isError($r)) 
				die(print_r($r, 1));
		}
		// Update the optional properties
		break;

	case 'get':
		$now = time()-60*10;
		$r = $db->getall($sql_number, array($now));
		$seq = new Frame(Frame::SEQUENCE, 0, array('no' => $r[0][0]));
		$seq->pack();
		print_r($seq);

		$r = $db->query($sql_details, array($now));
		if (DB::isError($r)) 
			die(print_r($r, 1));

		while ($r->fetchInto($row, DB_FETCHMODE_ASSOC)) {
			$gid = $row['id'];
			$details = array(
				'name'		=> $row['name'],
				'tp'		=> explode(',', $row['tp']),
				'server'	=> $row['server'],
				'sertype'	=> $row['sertype'],
				'rule'		=> $row['rule'],
				'rulever'	=> $row['rulever'],
				'locations'	=> array(),
				'optional'  => array(),
			);

			// Get all the locations for this game
			$gid   = $row['id'];
			do {
				$details['locations'][] = array($row['type'], $row['host'], $row['ip'], $row['port']);

				$lastseen = max($row['lastseen'], $lastseen);
				if ($gid != $row['id'])
					break;
			} while ($r->fetchInto($row, DB_FETCHMODE_ASSOC));

			$details['lastseen'] = $lastseen;

			$game = new Frame(Frame::GAMES, 0, $details);
			$game->pack();
			print_r($game);
		}

		break;
	default:

		$title = "Metaserver Server Listing";
#		include "bits/start_page.inc";

		$now = time()-60*10;
		$r = $db->query($sql_details, array($now));
		if (DB::isError($r)) 
			die(print_r($r, 1));
		while ($r->fetchInto($row, DB_FETCHMODE_ASSOC)) {
#			include "bits/start_section.inc";

			print "<h1>{$row['name']}</h1>\n";
			print "<p>Running on {$row['sertype']} (Version: {$row['server']})</p>\n";
			print "<p>Playing {$row['rule']} (Version: {$row['rulever']})</p>\n";
			print "<p>Can be connected to via:\n<ul>\n";

			$names = array(
				'tp' 		=> 'Standard Connection',
				'tps'		=> 'Secure Connection',
				'tphttp'	=> 'HTTP Tunnel Connection',
				'tphttps'	=> 'Secure HTTP Tunnel Connection',
			);
			// Get all the locations for this game
			$gid   = $row['id'];
			do {
				print "<li>";
				print "<a href='{$row['type']}://{$row['host']}:{$row['port']}/{$row['name']}'>";
				print $names[$row{'type'}]." to ";
				print "{$row['host']} ({$row['ip']}:{$row['port']})";
				print "</a></li>\n";
				if ($gid != $row['id'])
					break;
			} while ($r->fetchInto($row, DB_FETCHMODE_ASSOC));
			print "</ul></p>";
#			include "bits/end_section.inc";
		}
		break;
}
