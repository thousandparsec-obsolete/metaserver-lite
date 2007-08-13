<?php

/**
	
	:/ don't know if it work's :/

*/

class GameConnect{

	private $host;
	private $port;
	private $socket;
	
	
	public function connectToGame($host, $port)
	{
		//prabobly to change\
		echo "connecting<br />";
		echo $this->socket =& socket_create(AF_INET, SOCK_STREAM, 0);// or die("Could not create socket\n");
		echo socket_connect($this->socket, $host, $port) ;//or die("Could not connect to server\n");
		echo "connected<br />";
	}
	
	public function getMassage($lenght)
	{
		$msg = socket_read($this->socket, $lenght)  or die("Could not send data to server\n");
		return $msg;
	}
	
	public function sendMessage($message)
	{
		socket_write($this->socket,$message) or die("Could not read server response\n");
	}
	
}


?>