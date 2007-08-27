<?php
   
  class Calendar {
    /**
     
    draw calendar in form of table for given year/month, and also mark selected day
     
    @param year  - year
    @param month - month
    @param type  -
    @param link  - link added to all days/month/year to remember all variables
    @param mark  - selected day isn't link - to show whith day we selected
     
    */
    public static function draw($year, $month, $type, $link = "", $mark = 0)
    {
       
      $first_day = mktime(0, 0, 0, $month, 1, $year);
      $last_day = mktime(23, 59, 59, $month+1, 0, $year);
       
      $day_count = ($last_day - $first_day + 1)/(60 * 60 * 24);
       
      $fd = getdate($first_day);
      $first_week_day = $fd['wday'];
       
      $return = "<table style='text-align:center'>";
      $return .= "<tr>
        <td>
        <a href='$link&amp;year=".($year-1)."&amp;month=$month&amp;day=0&amp;type=3'>&lt;&lt;</a>
        </td>
        <td style='text-align:center' colspan='5'>
        <a href='$link&amp;year=$year&amp;month=$month&amp;day=0&amp;type=3'>$year</a>
        </td>
        <td>
        <a href='$link&amp;year=".($year+1)."&amp;month=$month&amp;day=0&amp;type=3'>&gt;&gt;</a>
        </td>
        </tr>";
      $return .= "<tr>
        <td>
        <a href='$link&amp;year=$year&amp;month=".($month-1)."&amp;day=0&amp;type=2'>&lt;&lt;</a>
        </td>
        <td style='text-align:center' colspan='5'>
        <a href='$link&amp;year=$year&amp;month=$month&amp;day=0&amp;type=2'>
        ".$fd['month']."
        </a>
        </td>
        <td>
        <a href='$link&amp;year=$year&amp;month=".($month+1)."&amp;day=0&amp;type=2'>&gt;&gt;</a>
        </td>
        </tr>";
      $return .= "<tr><td>S</td><td>M</td><td>T</td><td>W</td><td>T</td><td>F</td><td>S</td></tr>";
       
      $now = 1;
      $return .= "<tr>";
      for ($i = 0; $i < 7; $i++)
      {
        if ($i < $first_week_day)
          {
           
          $return .= "<td> </td>";
        }
        else if ($i >= $first_week_day )
        {
          $return .= "<td>";
          if ($mark == $now)
            {
            $return .= "<b>$now</b>";
          }
          else $return .= "<a href='$link&amp;year=$year&amp;month=$month&amp;day=$now&amp;type=1'>$now</a>";
          $return .= "</td>";
          $now++;
        }
         
      }
       
      $return .= "</tr>";
      while ($now <= $day_count)
      {
        $return .= "<tr>";
        for($i = 0 ; $i < 7 && $now <= $day_count; $i++)
        {
          $return .= "<td>";
          if ($mark == $now)
            {
            $return .= "<b>$now</b>";
          }
          else $return .= "<a href='$link&amp;year=$year&amp;month=$month&amp;day=$now&amp;type=1'>$now</a>";
          $return .= "</td>";
          $now++;
        }
        if ($i != 6)
          {
          for ($i ; $i < 7 && $now <= $day_count; $i++)
          $return .= "<td> </td>";
        }
        $return .= "</tr>";
      }
      $return .= "</table>";
       
      return $return;
    }
     
  }
