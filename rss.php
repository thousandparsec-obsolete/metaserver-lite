<?php

require_once "DB.php";
require_once "class/Backend.php";
require_once "class/Rss.php";

// FIXME: This isn't going to work everywhere..
Rss::createRss('http://www.tarl.org/~niphree/parsec/');
