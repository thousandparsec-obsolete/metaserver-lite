<?php


	class Calendar {

		
		public static function draw($year, $month, $type, $link = "", $mark = 0)
		{
			
				$first_day = mktime(0,0,0,$month, 1, $year);
				$last_day = mktime(23,59,59,$month+1, 0, $year);
				
				$day_count = ($last_day - $first_day + 1)/(60*60*24);
				
				$fd = getdate($first_day);
				$first_week_day = $fd['wday'];
				
		
				
				
				$return = "<table style=\"text-align:center\">";
				$return.="<tr>
						      <td>
	                     	<a href=\"".$link."&year=".($year-1)."&month=$month&day=0&type=3\">&lt;&lt;</a> 
	                     </td>
	                     <td style=\"text-align:center\" colspan=\"5\">  
	                     	<a href=\"".$link."&year=".$year."&month=$month&day=0&type=3\">".$year."</a>
	                     </td>
	                     <td>
	                     	<a href=\"".$link."&year=".($year+1)."&month=$month&day=0&type=3\">&gt;&gt;</a>
	                     </td>
							</tr>";
				$return.="<tr>
								<td>
	                     	<a href=\"".$link."&year=".$year."&month=".($month-1)."&day=0&type=2\">&lt;&lt;</a> 
	                     </td>
	                     <td style=\"text-align:center\" colspan=\"5\">  
	                     	<a href=\"".$link."&year=".$year."&month=".$month."&day=0&type=2\">
		                     	".$fd['month']."
		                  	</a>
	                     </td>
	                     <td>
	                     	<a href=\"".$link."&year=".$year."&month=".($month+1)."&day=0&type=2\">&gt;&gt;</a>
	                     </td>
	         			</tr>";
				$return.="<tr><td>S</td><td>M</td><td>T</td><td>W</td><td>T</td><td>F</td><td>S</td></tr>";
				
				$now = 1;
				$return.="<tr>";
				for ($i = 0; $i<7; $i++)
				{
					if ($i < $first_week_day)
					{
						
						$return.="<td> </td>";
					}
				   else if ($i >= $first_week_day )
					{
						$return.="<td>";
							if ($mark == $now)
							{
								$return.="<b>".$now."</b>";
							}
							else $return.="<a href=\"".$link."&year=$year&month=$month&day=$now&type=1\">".$now."</a>";
						$return.="</td>";
						$now++;
					}

				}
				
				$return.="</tr>";
				while ($now <= $day_count)
				{
					$return.="<tr>";
					for($i = 0 ; $i<7 && $now <= $day_count; $i++)
					{
						$return.="<td>";
						   if ($mark == $now)
							{
								$return.="<b>".$now."</b>";
							}
							else $return.="<a href=\"".$link."&year=$year&month=$month&day=$now&type=1\">".$now."</a>";
						$return.="</td>";
						$now++;
					}
					if ($i != 6)
					{
						for ($i ; $i<7 && $now <= $day_count; $i++)
						$return.="<td> </td>";
					}
					$return.="</tr>";
				}
				
				
				$return.="</table>";
				
				return $return;
			
		}

	}


?>