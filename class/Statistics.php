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
   

   Class process data from database, that it could be use in charts.
   It also displays it in table form
   
   
  */
  class Statistics {
     
    private $date_type;
    private $stat_type;
     
    private $year;
    private $month;
    private $day;
     
    private $data = Array();
     
     /**
     
     class constructor to determinate stats type
     @param date_type   - 1,2 or 3. if 1: stats for day, month, year, if 2: stats for month, year, if 3: stats for year
     @param stat_type   - 1 or 2. if 1 - stats only for one aggregate function, else for 3 functons (used only if displaying table)
     
     */
    public function __construct($date_type, $stat_type)
    {
      $this->date_type = $date_type;
      $this->stat_type = $stat_type;
    }
     
     /**
     sets data. 
     @param year - year
     @param month - month, if 0 : year stats
     @param day - day, if 0 : month stats
     */
    public function set_time($year, $month = 0, $day = 0)
    {
      $this->year = $year;
      $this->month = $month;
      $this->day = $day;
    }
     
     
     /**
     	
     	set data.
     	
     	@param data1 - data from databes
     	
     	
     */
    public function read_data($data1, $data2 = 0, $data3 = 0)
    {
      if ($this->stat_type == 1)
        $this->formatDataType1($data1);
      else if ($this->stat_type == 2)
      $this->formatDataType2($data1 , $data2 , $data3);
      else throw new Exception("wrong parameters or data type");
       
    }
     
     
     /**
     format data. in given key (date) we will have statistics for this date in array
     @param data - data to insert into array
     
     */
    private function formatDataType1($data)
    {
      foreach($data as $row)
      {
        $this->data[$this->formatKey($row[0]) ] = $row[1];
      }
       
    }
     
     
     /**
     format data. in given key (date) we will have statistics for this date in array
     @param data - data to insert into array
     
     */
    private function formatDataType2($data1, $data2 , $data3 )
    {
      foreach ($data1 as $key => $value)
      {
         
        $this->data[$this->formatKey($value[0])][0] = ($value[1]);
         
      }
      foreach ($data2 as $key => $value)
      {
         
        $this->data[$this->formatKey($value[0])][1] = ($value[1]);
         
      }
      foreach ($data3 as $key => $value)
      {
         
        $this->data[$this->formatKey($value[0])][2] = ($value[1]);
         
      }
       
    }
     
     /**
     return formated date from key 
     @param key - key from data table
     
     @return formated date
     
     */
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
      else throw new Exception("wrong date type");
       
    }
     
     /**
     test function for print data array
     
     */
    public function print_()
    {
      print_r($this->data);
    }
     
    /*
    
    print table. 
    I've done lots of style class - so it would be easier to change style of elements
     
    @param header_key - header for date row.
    @param header_data1 - header for stats row
    @return table definition string
    */
    public function print_table($header_key = "", $header_data1 = "" , $header_data2 = "" , $header_data3 = "" )
    {
      $i = 0;
      $return = "<table class='stat_table' style=\"margin: 0 auto\">";
       
      if ($this->stat_type == 1)
        $return .= "<tr class='header_tr_stat1'>
        <td class='header_td_stat1_key'>$header_key</td>
        <td class='header_td_stat1_1'>$header_data1</td>
        </tr>";
      else if($this->stat_type == 2)
      {
        $return .= "<tr class='header_tr_stat2'>
          <td class='header_td_stat2_key'>$header_key</td>
          <td class='header_td_stat2_1'>$header_data1</td>
          <td class='header_td_stat2_2'>$header_data2</td>
          <td class='header_td_stat2_3'>$header_data3</td>
           
          </tr>";
      }
       
       
       
      foreach ($this->data as $key => $value)
      {
         
        if ($this->stat_type == 1 )
          $return .= "<tr class='tr_stat1'>
          <td class='td_stat1_key'>$key</td>
          <td class='td_stat1_1'>$value</td>
          </tr>";
        else if($this->stat_type == 2)
        {
          $return .= "<tr class='tr_stat2'>
            <td class='td_stat2_key'>".$key."</td>
            <td class='td_stat2_1'>".$value[0]."</td>
            <td class='td_stat2_2'>".$value[1]."</td>
            <td class='td_stat2_3'>".$value[2]."</td>
             
            </tr>";
        }
         
         
      }
      $return .= "</table>";
       
      return $return;
    }
    
    /**
    return data, that can be use in for example in flash charts
    
    @return formated data
    
    */
    public function getData()
    {
      return $this->data;
    }
  }