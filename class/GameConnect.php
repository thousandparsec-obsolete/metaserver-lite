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
		//prabobly to change
		$this->socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		socket_connect($this->socket, $host, $port) or die("Could not connect to server\n");
	}
	
	public function getmassage()
	{
		socket_read($this->socket, 1024)  or die("Could not send data to server\n");
		return $msg;
	}
	
	public function sendMessage($message)
	{
		socket_write($this->socket, 1024) or die("Could not read server response\n");
	}
	
}


?>