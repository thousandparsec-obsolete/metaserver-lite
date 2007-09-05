<?php
   
  require_once "DB.php";
  require_once "class/Backend.php";
  require_once "class/Rss.php";
  require_once "config.php";
   

   
  Rss::createRss($main_site, $dsn);

