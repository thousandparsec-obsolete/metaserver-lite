<?php
   
  /**
  
  Class that connect to game server and send/recieve message from server.
  
  */
  class GameConnect {
    private $socket;
  	
  	 /**
  	 connect to game server
  	 
  	 @param host - game adress
  	 @param port - port
  	 
  	 */  
    public function __construct($host, $port)
    {
		if ( ( $this->socket = & socket_create(AF_INET, SOCK_STREAM, 0) ) === false )
			throw new Exception("Could not create socket\n");
      socket_set_option($this->socket,
        SOL_SOCKET,  // socket level
        SO_RCVTIMEO, // timeout option
      array(
      "sec" => 10, // Timeout in seconds
      "usec" => 0 // I assume timeout in microseconds
      )
      );
       
      // FIXME: Die instead of an exception!
      if (socket_connect($this->socket, $host, $port) === false)
      	throw new Exception("Could not connect to server\n");
      //echo "connected<br />";
    }
     
    /**
    get message from socket
     
    @param length - lenght of message
    @return message from server
    */
    public function getMessage($length)
    {
      if (false === ($msg = socket_read($this->socket, $length)) )
        {
        socket_close($this->socket->socket_close);

        throw new Exception("Could not send data to server\n");
      };
      return $msg;
    }
     
     
    /**
    send message
     
    @param message - message
    */
    public function sendMessage($message)
    {
      if (false === (socket_write($this->socket, $message) ))
        {
        socket_close($this->socket);

        throw new Exception("Could not read server response\n");
      };
    }
     
    /**
     
    */
    public function disconnect()
    {
      socket_close($this->socket);
    }
  }