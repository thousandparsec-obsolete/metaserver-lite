<?php


// ?? check this library !!! 





class RSS {


	/**
	create RSS feed
	
	@param link - link to main metaserver site
	
	*/
	public static function createRss($link)
	{
		
		
		$dsn = "mysqli://intart2_8:parsec@sql.intart2.nazwa.pl:3305/intart2_8";

		$time = time();

		$db = new Backend($dsn, $time);
		
		//!! make function from this !!!!!
		
		$sql_details = "
      SELECT
      	games.id, name, tp, server, sertype, rule, rulever,
      	type, host, ip, port, locations.lastseen AS lastseen, firstseen
      FROM
      	games
      JOIN
      	locations ON games.id = locations.gid
      WHERE
			 locations.lastseen > ?
      ORDER BY
      	firstseen 
      LIMIT 5";
      	
      
		$r = $db->db->query($sql_details, array($time-60*10));
			
		if (DB::isError($r)) 
			die(print_r($r, 1));
		echo 
			'<?xml version="1.0" encoding="utf-8"?>
			<rss version="2.0" xml:base="http://www.thousandparsec.net/tp/" xmlns:dc="http://purl.org/dc/elements/1.1/">
			 	<channel>
			 		<title>Thousand Parsec New Games</title>
				   <link>'.$link.'</link>
			    	<description>Information about Thousand Parsec new Games</description>
				   <language>en-us</language>';
				   
				   
				   

		$r->fetchInto($row, DB_FETCHMODE_ASSOC);
		echo '<lastBuildDate>'.date(DATE_RFC822, $row['firstseen']).'</lastBuildDate>';
		while (true) 
		{
			if (sizeof($row) == 0)
				break;	
      	$gid   = $row['id'];

			
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
			
			echo '<item>
						<title>'.$row['name'].'</title> 
						<link>'.$link.'</link>';
			echo "<pubDate>".date(DATE_RFC822, $row['firstseen'])."</pubDate>";
			echo "	<description>
							Running on {$row['sertype']} (Version: {$row['server']}) playing {$row['rule']} (Version: {$row['rulever']}) - {$optional['cmt']}
						".htmlspecialchars("<br /><br />");
						
			echo htmlspecialchars("<p>");

			if (array_key_exists('turn', $optional)) {
					$date = gmdate("H:i:s, M d Y", $optional['turn']);
					$away = $optional['turn']-time();

					if ($away < 0)
						$away = "now";
					echo "The next turn will be generated at $date (UTC) which is ~$away seconds away. ";
				}
				htmlspecialchars("<br />");
				if (array_key_exists('cons', $optional))
					echo "There are currently {$optional['cons']} clients connected. ";
				if (array_key_exists('plys', $optional))
					echo "The game has currently {$optional['plys']} players. ";
				if (array_key_exists('objs', $optional))
					echo "The Universe currently has {$optional['objs']} objects. ";
				if (array_key_exists('admin', $optional)) {
					// FIXME: Should obscure the email somehow...
					$email = $optional['admin'];
					echo htmlspecialchars("The admin contact for this server is <a href='mailto:$email'>$email</a>.");
				}
				echo htmlspecialchars("</p>");

				// Get all the locations for this game
				echo htmlspecialchars("<p>Can be connected to via:\n<ul>\n");

				$names = array(
					'tp' 		=> 'Standard Connection',
					'tps'		=> 'Secure Connection',
					'tphttp'	=> 'HTTP Tunnel Connection',
					'tphttps'	=> 'Secure HTTP Tunnel Connection',
				);
			do {
					if ($gid != $row['id'])
					{
						break;
					}

					echo htmlspecialchars("<a href='{$row['type']}://{$row['host']}:{$row['port']}/".urlencode("{$row['name']}")."'>");
					echo htmlspecialchars($names[$row{'type'}]." to ");
					echo htmlspecialchars("{$row['host']} ({$row['ip']}:{$row['port']})");
					echo htmlspecialchars("</a></li>\n");
				} while ($r->fetchInto($row, DB_FETCHMODE_ASSOC));
			echo "</description></item>";
		}
			
		echo '</channel>
			</rss>';
			
			
				
	}
	
}
	

?>