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
	
		$canvas =& Image_Canvas::factory('png', array('width' => 400, 'height' => 400, 'antialias' => true)); 
		$graph =& Image_Graph::factory('graph', $canvas);
		
		//$font =& $graph->addNew('font', 'Verdana');     				
		//$font->setSize(9);
		//$graph->setFont($font);
		
		$graph->add(
    		Image_Graph::vertical(
				Image_Graph::vertical(
					Image_Graph::factory('title', array('Statistics', 12)),
					Image_Graph::factory('title', array('additional data', 8)),
					80
				),
				Image_Graph::vertical(
					$plotarea = Image_Graph::factory('plotarea'),
					$legend = Image_Graph::factory('legend'),
					85
				),
			9)
		); 
		

		$gridY =& $plotarea->addNew('line_grid', null, IMAGE_GRAPH_AXIS_Y); 
		$gridY->setLineColor('gray@0.1'); 
		$gridX =& $plotarea->addNew('line_grid', null, IMAGE_GRAPH_AXIS_X);
		$gridX->setLineColor('lightgray@0.1');  

		$axisX =& $plotarea->getAxis(IMAGE_GRAPH_AXIS_X);
		$axisX->setFontAngle('vertical'); 
		
		if ($stat_type == 1)
		{
			$dataset =& Image_Graph::factory('dataset'); 
			foreach ($data as $key=>$value)
			{
				$dataset->addPoint($key."  ",$value);
				
				 
			}
			
			$plot =& $plotarea->addNew('line', array(&$dataset)); 
			
			$plot->setLineColor('blue'); 
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