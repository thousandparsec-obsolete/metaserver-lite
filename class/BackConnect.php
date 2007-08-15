<?php

/*change path later!!!!*/

include('Frame.php');




class BackConnect
{
	private $game_connect;
	
	public function __construct($host, $port)
	{
		$this->game_connect = new GameConnect($host, $port);
		
	}
	
	
	/**
	
	ADD return values /okey/fail/
	*/
	public function connect()
	{
		$f = new Frame(Frame::CONNECT, 1, array("s"=>"neah"));
	   $message = $f->pack();
	   $this->game_connect->sendMessage($message);
	   //16 bits header frame
	   $res = $this->game_connect->getMessage(16);
	   print_r($f);
	   $f->parse_header($res);
	   print_r($f);
	   $res = $this->game_connect->getMessage($f->length);
	   echo $res;
	   $f->parse_data($res);
	   print_r($f);
	}
	
	public function get_games()
	{
		echo "<br />GETGAMES Frame:<br />";
		$f = new Frame(Frame::GETGAMES, 1, array());
	   $message = $f->pack();
	   echo "<br />message:".$message."<br />";
	   $this->game_connect->sendMessage($message);
	   //16 bits header frame
	   $res = $this->game_connect->getMessage(16);
	   echo "header rec:<br />";
	   print_r($f);
	   $f->parse_header($res);
	   echo "<br />frame :<br />";
	   print_r($f);
	   $res = $this->game_connect->getMessage($f->length);
	   echo "<br />res:<br />";
	   echo $res;
	   $f->parse_data($res);
	   echo "<br />frame:<br />";
	   print_r($f);
	
	}
	
	

}

?>