<?php

/**
	
	:/ don't know if it work's :/

*/

class GameConnect{

	
	private $socket;
	
	
	public function __construct($host, $port)
	{
		//prabobly to change\
		echo "connecting<br />";
		 $this->socket =& socket_create(AF_INET, SOCK_STREAM, 0);// or die("Could not create socket\n");
		 socket_connect($this->socket, $host, $port) ;//or die("Could not connect to server\n");
		echo "connected<br />";
	}
	
	public function getMessage($length)
	{
		$msg = socket_read($this->socket, $length)  or die("Could not send data to server\n");
		return $msg;
	}
	
	public function sendMessage($message)
	{
		socket_write($this->socket,$message) or die("Could not read server response\n");
	}
	
}


?>