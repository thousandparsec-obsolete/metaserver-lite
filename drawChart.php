<?php
  require_once "class/SwfCharts.php";
  require_once "DB.php";
  require_once "class/Backend.php";
  require_once "class/Statistics.php";
  require_once "config.php";
   
  //echo "&title=Statistics,15,#000080& &x_axis_steps=1& &y_ticks=5,10,5& &line=3,#87421F& &values=1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1& &x_labels=0:00,1:00,2:00,3:00,4:00,5:00,6:00,7:00,8:00,9:00,10:00,11:00,12:00,13:00,14:00,15:00& &y_min=0& &y_max=20&";
  try {
    // FIXME: This should be in config.php
     
     
     
    $time = time();
     
    $db = new Backend($dsn, $time);
     
    $data2 = unserialize(base64_decode($_GET['data_']));
     
    $type = $data2[0];
    $opt = $data2[1];
    $year = $data2[2];
    $month = $data2[3];
    $day = $data2[4];
    $agr = $data2[5];
    $gid = $data2[6];
     
     
     
    if ($type == 1)
      {
      if ($gid == 0 )
        $r = $db->getStatisticFromOptional ($opt, $year , $month, $day, $agr );
      else
        $r = $db->getStatisticFromOptional ($opt, $year , $month, $day, $agr, $gid );
       
    }
    if ($type == 2)
      {
      if ($gid == 0 )
        $r = $db->getStatisticFromOptional ($opt, $year , $month, 0, $agr );
      else
        $r = $db->getStatisticFromOptional ($opt, $year , $month, 0, $agr , $gid);
       
    }
    if ($type == 3)
      {
      if ($gid == 0 )
        $r = $db->getStatisticFromOptional ($opt, $year , 0, 0, $agr );
      else
        $r = $db->getStatisticFromOptional ($opt, $year , $month, 0, $agr , $gid);
       
    }
     
    $stat = new Statistics($type, 1);
    $stat->read_data($r);
    $data_ = $stat->getData();
     
    $chartdata = SwfCharts::drawPlotChart($data_, $type);
     
    echo $chartdata;
     
  }
  catch (Exception $e)
  {
     
    //FIXME: This should probably have more then just the error message?
    // What about the heading/footer
    echo $e->getMessage();
     
  }
   
?>

