<?php
require_once "../class/SwfCharts.php";

//echo "&title=Statistics,15,#000080& &x_axis_steps=1& &y_ticks=5,10,5& &line=3,#87421F& &values=1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1& &x_labels=0:00,1:00,2:00,3:00,4:00,5:00,6:00,7:00,8:00,9:00,10:00,11:00,12:00,13:00,14:00,15:00& &y_min=0& &y_max=20&";

$data2 = unserialize(base64_decode($_GET['data_']));

$data = $data2['data'];
$type = $data2['type'];

$chartdata = SwfCharts::drawPlotChart($data, $type);

echo $chartdata;



?>