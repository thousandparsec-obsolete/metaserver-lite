<?php
   
   
  class GameConnect {
     
     
    private $socket;
     
     
    public function __construct($host, $port)
    {
      //prabobly to change\
      //echo "connecting<br />";
      $this->socket = & socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
      socket_set_option($this->socket,
        SOL_SOCKET, // socket level
      SO_RCVTIMEO, // timeout option
      array(
      "sec" => 10, // Timeout in seconds
      "usec" => 0 // I assume timeout in microseconds
      )
      );
       
      socket_connect($this->socket, $host, $port) or die("Could not connect to server\n");
      //echo "connected<br />";
    }
     
    /**
    get message from socket
     
    @param length - lenght of message
    */
    public function getMessage($length)
    {
      if (false === ($msg = socket_read($this->socket, $length)) )
        {
        socket_close($this->socket->socket_close);
        die("Could not send data to server\n");
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
        die("Could not read server response\n");
      };
    }
     
    /**
     
    */
    public function disconnect()
    {
      socket_close($this->socket);
    }
     
     
  }
   
   
?>

