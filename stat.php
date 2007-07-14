<?php


	require_once "DB.php";
	require_once "class/Backend.php";
	require_once "class/Statistics.php";
	require_once "class/Calendar.php";
	require_once "class/Charts.php";
	require_once 'Image/Graph.php';
	require_once 'Image/Canvas.php'; 

	/**

	inserting some test data

	*/

	$dsn = "mysqli://intart2_8:parsec@sql.intart2.nazwa.pl:3305/intart2_8";

	$time = time();

	$db = new Backend($dsn, $time);
	
	$time_array = getdate();
	
	$month = $_REQUEST['month'];
	$day = $_REQUEST['day'];
	$year = $_REQUEST['year'];
	$type = $_REQUEST['type'];
	$graph = $_REQUEST['graph'];
	$agr = $_REQUEST['agr'];
	$opt = $_REQUEST['opt'];
	$gid = $_REQUEST['gid'];
	
	
	
	if ($month == "")
		$month = $time_array['mon'];
	if ($day == "")
		$day = $time_array['mday'];
	if ($year == "")
		$year = $time_array['year'];
	if ($type == "")
		$type = 1;
	/*
		1 - table
		2 - graph
	*/
	if ($graph == "")
		$graph = 1;
	if ($agr == "")
		$agr = 'avg';
	if ($opt == "")
		$opt = 'plys';
	if ($gid == "")
		$gid = 0;
	
	
	
	if ($type == 1)
	{
		if ($gid == 0 )
			$r = $db->getStatisticFromOptional ($opt,  $year , $month, $day, $agr );
		else
			$r = $db->getStatisticFromOptional ($opt,  $year , $month, $day, $agr, $gid );
	}
	if ($type == 2)
	{
		if ($gid == 0 )
			$r = $db->getStatisticFromOptional ($opt,  $year , $month, 0, $agr );
		else
			$r = $db->getStatisticFromOptional ($opt,  $year , $month, 0, $agr , $gid);
	}
	if ($type == 3)
	{
		if ($gid == 0 )
			$r = $db->getStatisticFromOptional ($opt,  $year , 0, 0, $agr );
		else
			$r = $db->getStatisticFromOptional ($opt,  $year , $month, 0, $agr , $gid);
	}

	$stat = new Statistics($type, 1);
	$stat->read_data($r);
	$data = $stat->getData();
	
	
	
	 
	include "bits/start_page.inc";
	
	//
	
	?>
		<div id="right" style="width: 300px;">
		<?php include "bits/start_section.inc"; ?> 
		<div class="stats">
	<?
		
		echo Calendar::draw($year,$month,"stat.php?graph=".$graph."&agr=".$agr."&opt=".$opt."&gid=".$gid, $day);
		
		echo "<br />agregate functions:<br /><br />
				<table width=\"200px\">
					<tr>
						<td>
							<a href=\"stat.php?graph=".$graph."&agr=max&opt=".$opt."&month=".$month."&year=".$year."&day=".$day."&type=".$type."&gid=".$gid."\">
								max
							</a>
						</td>
						<td>
							<a href=\"stat.php?graph=".$graph."&agr=avg&opt=".$opt."&month=".$month."&year=".$year."&day=".$day."&type=".$type."&gid=".$gid."\">
								avg
							</a>
						</td>
						<td>
							<a href=\"stat.php?graph=".$graph."&agr=min&opt=".$opt."&month=".$month."&year=".$year."&day=".$day."&type=".$type."&gid=".$gid."\">
								min
							</a>
						</td>
						
					</tr>
			</table>";
		echo "<br />choose paremeter:<br /><br />";
		/*
			plys  	1  	number of players in the game
			cons 	2 	number of clients currently connected
			objs 	3 	number of "objects" in the game universe
		*/
			echo "<a href=\"stat.php?graph=".$graph."&agr=".$agr."&opt=plys&month=".$month."&year=".$year."&day=".$day."&type=".$type."&gid=".$gid."\">
					number of players in the game
				</a><br />";
			echo "<a href=\"stat.php?graph=".$graph."&agr=".$agr."&opt=cons&month=".$month."&year=".$year."&day=".$day."&type=".$type."&gid=".$gid."\">
					number of clients currently connected
				</a><br />";
			echo "<a href=\"stat.php?graph=".$graph."&agr=".$agr."&opt=objs&month=".$month."&year=".$year."&day=".$day."&type=".$type."&gid=".$gid."\">
					number of \"objects\" in the game universe
				</a><br />";
				
		echo "<br />choose server:<br /><br />";
		echo "<a href=\"stat.php?graph=".$graph."&agr=".$agr."&opt=".$opt."&month=".$month."&year=".$year."&day=".$day."&type=".$type."&gid=0\">
					all
				</a><br />";
	
		/*
			put this into Backend class later!!
		*/
		$sql_details = "
      SELECT
      	id, name
      FROM
      	games
      ORDER BY
      	id";
      	
		$res = $db->db->query($sql_details);
		$res->fetchInto($row, DB_FETCHMODE_ASSOC);
		while (true) 
		{
			if (sizeof($row) == 0)
				break;

			
			echo "<a href=\"stat.php?graph=".$graph."&agr=".$agr."&opt=".$opt."&month=".$month."&year=".$year."&day=".$day."&type=".$type."&gid=".$row['id']."\">
					".$row['name']."
				</a><br />";
			$res->fetchInto($row, DB_FETCHMODE_ASSOC);
			
		}
		
	?>
	
	</div>
<?php include "bits/end_section.inc"; ?> 
</div>

<?

	
	
	if ($graph == 1)
	{
		echo "<div style=\"text-align:center\">";
		echo "<br /><br /><br />";
		if ($type == 1)
			$par1 = "hour";
		if ($type == 2)
			$par1 = "day";
		if ($type == 3)
			$par1 = "month";
		
		echo $stat->print_table($par1, $agr);
		echo "
		<br /><br />

		<a href=\"stat.php?graph=2&agr=".$agr."&opt=".$opt."&month=".$month."&year=".$year."&day=".$day."&type=".$type."&gid=".$gid."\">
								change to graph
							</a>
		</div>";
	}
	else 
	{
		echo "<div style=\"text-align:center;margin-right:30px;\">";
		"<br /><br />";
		Charts::drawPlotChart($data, 2);
		echo "
		<br /><br />

		<a href=\"stat.php?graph=1&agr=".$agr."&opt=".$opt."&month=".$month."&year=".$year."&day=".$day."&type=".$type."&gid=".$gid."\">
								change to table
							</a>
		</div>";
	}
	

	
	
	//$r = $db->getStatisticFromOptional ('plys', 2007 , 0, 1 );
	
	

	

	
	 
?>