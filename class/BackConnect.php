<?php
  // FIXME: This should include from the correct location 
  /*change path later!!!!*/
  //include('Frame.php');
   
  class BackConnect {
    private $game_connect;
    private $frame;
     
    public function __construct($host, $port)
    {
      // Where does game_connect come from?
      $this->game_connect = new GameConnect($host, $port);
    }
     
     
    /**
    connect to game

    FIXME: Where is the error checking here?
      - The server could return a failed frame...
      - The the connection string should be something like "Backconnect from Metaserver ($version) $hostname".
    */
    public function connect()
    {
      $f = new Frame(Frame::CONNECT, 1, array("s" => "neah"));
      $message = $f->pack();
      $this->game_connect->sendMessage($message);
      //16 bits header frame
      $res = $this->game_connect->getMessage(16);
       
      $f->parse_header($res);
       
      $res = $this->game_connect->getMessage($f->length);
       
      $f->parse_data($res);
      
      $f->
    }
     
    /**
    get all games. data stored in frame

    FIXME: Where is the error checking here?
      - The server could return a failed frame...
    */
    public function get_games()
    {
      $this->frame = new Frame(Frame::GETGAMES, 1, array());
      $message = $this->frame->pack();
       
      $this->game_connect->sendMessage($message);
      $res = $this->game_connect->getMessage(16);
       
      $this->frame->parse_header($res);
      $res = $this->game_connect->getMessage($this->frame->length);
       
      $this->frame->parse_data($res);
    }
     
    public function disconnect()
    {
      $this->game_connect->disconnect();
    }
     
    /**
    @todo - add frame formating
    */
    public function writeFrame()
    {
      print_r($this->frame);
    }
     
    public function getFrame()
    {
      return $this->frame;
    }
     
  }