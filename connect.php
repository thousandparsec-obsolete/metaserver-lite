<?php


require_once "class/GameConnect.php";
//put this in different file !!!!
require_once "class/Frame.php";


$gc = new GameConnect();

$gc->connectToGame('203.122.246.117', 6923);

												//clieant name 
$f = new Frame(Frame::CONNECT, 1, array("s"=>"neah"));
$message = $f->pack();
echo "a1";
$gc->sendMessage($message);
echo "a2";
//16 bits header frame
$res = $gc->getMassage(16);
echo "<br />".$res."<br />";
echo "a3";
//get lenght of message from header
print_r($f);
echo "a4";
$f->parse_header($res);
echo "a4";

print_r($f);

$res = $gc->getMassage($f->length);
echo $res;
echo "a6";
$f->parse_data($res);
print_r($f);
echo "a7";
echo $packet;


?>