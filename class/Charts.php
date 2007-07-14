<?php

	

	/*
	similar to Statistics, dataset looks like:
		stat_type:
			1 - key->valye
			2 - key->{min; avg; max}  
	
	
	*/
	 

class Charts {
	 


	
	public static function drawPlotChart($data, $stat_type) 
	{
		$canvas =& Image_Canvas::factory('png', array('width' => 700, 'height' => 600, 'antialias' => true)); 
		$graph =& Image_Graph::factory('graph', $canvas);
		
		//$font =& $graph->addNew('font', 'Verdana');     				
		//$font->setSize(9);
		//$graph->setFont($font);
		
		$plotarea =& $graph->addNew('plotarea');

		if ($stat_type == 1)
		{
			$dataset =& Image_Graph::factory('dataset'); 
			foreach ($data as $key=>$value)
			{
				$dataset->addPoint($key,$value);
			}
			
			$plot =& $plotarea->addNew('line', array(&$dataset)); 
			$plot->setLineColor('yellow'); 
		}
		else if($stat_type == 2)
		{
			$dataset[0] =& Image_Graph::factory('dataset'); 
			$dataset[1] =& Image_Graph::factory('dataset'); 
			$dataset[2] =& Image_Graph::factory('dataset'); 
			
			foreach ($data as $key=>$value)
			{
				$dataset[0]->addPoint($key,$value[0]);
				$dataset[1]->addPoint($key,$value[0]);
				$dataset[2]->addPoint($key,$value[0]);
			}
			
			$plot1 =& $plotarea->addNew('line', array(&$dataset[0])); 
			$plot2 =& $plotarea->addNew('line', array(&$dataset[1])); 
			$plot3 =& $plotarea->addNew('line', array(&$dataset[2])); 
			
			$plot1->setLineColor('green'); 
			$plot2->setLineColor('yellow'); 
			$plot3->setLineColor('blue'); 
			
		}
		else die("wrong parameter");
		echo $graph->done(
			Array('tohtml'=>true,
			'filename' => 'tmpimage.png',
         'filepath' => 'images/',
         'urlpath' => 'images/' 
			)
		);
		
	}
	

	
}


?>