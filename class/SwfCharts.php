<?php

	

	/*
	similar to Statistics, dataset looks like:
		stat_type:
			1 - key->valye
			2 - key->{min; avg; max}  
	
	
	*/
	 

class SwfCharts {


	public static function drawPlotChart($data, $stat_type) 
	{
		$tmp = array();
	   $x_labels = array();
	   foreach ($data as $key=>$value)
		{
			$tmp[] = $value;
			$x_labels[] = $key;
		}
	   	   
	   include_once( 'ofc-library/open-flash-chart.php' );
	   $g = new graph();
	   $g->set_data( $tmp );
	   $g->set_x_labels( $x_labels );
		$g->title( 'Statistics', 15, '#000080' );
	   $data = $g->render();
	
	   $filename = 'data.txt';


	   
	       if (!$handle = fopen($filename, 'w+')) {
	            exit;
	       }

	       // Write $somecontent to our opened file.
	       if (fwrite($handle, $data) === FALSE) {
	           exit;
	       }

	       fclose($handle);

	   
	   
	 

	}
}


?>