<?php

/*
	STATISTICS TYPE: (from constructor)
	data_type:
		1 - stats for: day, month, year
		2 - stats for: month, year
		3 - stats for: year
	
	stat_type:
		1 - key->valye
		2 - key->{min; avg; max}
	
	

*/


class Statistics {

	
	private $date_type;
	private $stat_type;
	
	private $year;
	private $month;
	private $day;
	
	private $data = Array();
	
	public function __construct($date_type, $stat_type) 
	{	
		$this->date_type = $date_type;
		$this->stat_type = $stat_type;
	}
	
	public function set_time($year, $month = 0, $day = 0)
	{
		$this->year = $year;
		$this->month = $month;
		$this->day = $day;
	}
	
	public function read_data($data1, $data2 = 0, $data3 = 0)
	{
		if ($this->stat_type == 1)
			$this->formatDataType1($data1);
		else if ($this->stat_type == 2)
			$this->formatDataType2($data1 , $data2 , $data3);
		else die("wrong parameters or data type");
			
	}
	
	private function formatDataType1($data)
	{
		foreach($data as $row)
		{
				$this->data[$this->formatKey($row[0]) ] = $row[1];
		}
	
	}

	private function formatDataType2($data1, $data2 , $data3 )
	{
		foreach ($data1 as $key=>$value)
		{
		
			$this->data[$this->formatKey($value[0])][0] = ($value[1]);
			
		}
		foreach ($data2 as $key=>$value)
		{
		
			$this->data[$this->formatKey($value[0])][1] = ($value[1]);
			
		}
		foreach ($data3 as $key=>$value)
		{
		
			$this->data[$this->formatKey($value[0])][2] = ($value[1]);
			
		}
		
	} 
	
	private function formatKey($key)
	{
		if ($this->date_type == 1)
		{
			return $key.":00";
		}
		else if ($this->date_type == 2)
		{
			$date = getdate(mktime (0, 0, 0, 1, $key));
			return $date['mday'];
		}
		else if ($this->date_type == 3)
		{
			$date = getdate(mktime (0, 0, 0, $key, 1 ));
			return "".$date['month']."";
		}
		else die("wrong date type");
		
	}
	
	public function print_()
	{
		print_r($this->data);
	}
	
	/*
		I've done lots of style class - so it would be easier to change style of elements
		
		@parameters 
		@return table definition string
	*/
	public function print_table($header_key = "",  $header_data1 = "" , $header_data2 = "" , $header_data3 = "" )
	{
		$i = 0;
		$return = "<table class='stat_table' style=\"margin: 0 auto\">";
		
		if ($this->stat_type == 1)
			$return.="<tr class='header_tr_stat1'>
				<td class='header_td_stat1_key'>$header_key</td>
				<td class='header_td_stat1_1'>$header_data1</td>
			 </tr>";
		else if($this->stat_type == 2)
		{
			$return.="<tr class='header_tr_stat2'>
				<td class='header_td_stat2_key'>$header_key</td>
				<td class='header_td_stat2_1'>$header_data1</td>
				<td class='header_td_stat2_2'>$header_data2</td>
				<td class='header_td_stat2_3'>$header_data3</td>
				
			 </tr>";
		}
		
		
		
		foreach ($this->data as $key => $value)
		{

			if ($this->stat_type == 1 )
			$return.="<tr class='tr_stat1'>
				<td class='td_stat1_key'>$key</td>
				<td class='td_stat1_1'>$value</td>
			 </tr>";
	  	  else if($this->stat_type == 2)
	     {
	     		$return.="<tr class='tr_stat2'>
	               <td class='td_stat2_key'>".$key."</td>
	               <td class='td_stat2_1'>".$value[0]."</td>
	               <td class='td_stat2_2'>".$value[1]."</td>
	               <td class='td_stat2_3'>".$value[2]."</td>
	               
	             </tr>";
	     }
			
			
		}
		$return.="</table>";
		
		return $return;
	}
	public function getData()
	{
		return $this->data;
	}
}









?>