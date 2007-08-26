<?php
// Check all the required properties exist in the request
     
  try
  {
    $required = array('sn', 'tp', 'server', 'sertype', 'rule', 'rulever');
    foreach ($required as $r)
    if (!array_key_exists($r, $_REQUEST))
      throw new Exception("Required key $r doesn't exist!");
    //include ("connect.php?")
  //  print "<pre>";
  //  var_dump($_REQUEST);
  //  print "</pre>";
     
     
    // Find the location details
    $location_values = array('type', 'dns', 'ip', 'port');
    $locations = array();
    while (1)
    {
      $i = count($locations);
       
      $location = array();
      foreach ($location_values as $k)
      {
        if (!array_key_exists($k.$i, $_REQUEST))
          throw new Exception ("Could not find $k$i");
        $location[$k] = $_REQUEST[$k.$i];
      }
      $locations[] = $location;
       
      if (!array_key_exists("type".count($locations), $_REQUEST))
        break;
    }
     
     
    include("connect.php");
     
     
     
     
     
    $result = $db->getKey($_REQUEST['sn'] );
    if (sizeof($result) > 0)
    {
      if (strcmp($result[0][0], $_REQUEST['key']) !== 0)
        throw new Exception ("Key was not valid...");
       
      // Update the required values
      $r = $db->update($_REQUEST['tp'],
        $_REQUEST['server'], $_REQUEST['sertype'],
        $_REQUEST['rule'], $_REQUEST['rulever'],
        $_REQUEST['sn'], $_REQUEST['ln'] );
    }
    else
    {
      $r = $db->insert(
      $_REQUEST['sn'], $_REQUEST['key'],
        $_REQUEST['tp'],
        $_REQUEST['server'], $_REQUEST['sertype'],
        $_REQUEST['rule'], $_REQUEST['rulever'], $_REQUEST['ln'] );
    }
     
     
     
    if (DB::isError($r))
      throw new Exception ("error: " . $r->getMessage () . "\n");
     
    // Get the ID
    $gid = $db->getId($_REQUEST['sn'] );
     
     
     
     
     
     
     
     
    // Validate the location stuff
    foreach ($locations as $location)
    {
      // Validate/format the data
      $valid_types = array('tp', 'tps', 'tphttp', 'tphttps');
       
      $type = $location['type'];
      if (!in_array($type, $valid_types))
        throw new Exception("Type $type was not valid");
       
      $addr_ = explode(' ', $location['ip']);
       
      $addr = explode('.', $addr_[0]);
      // Check that the ip address is valid
      if (sizeof($addr) != 4)
        throw new Exception("address wasn't a valid ip address");
      foreach($addr as $bit)
      {
         
        if (!is_numeric($bit) || $bit < 0 || $bit > 255)
          throw new Exception("address wasn't a valid ip address");
      }
       
      // Check that the ip address is not a private address
      $private_addr = array('192', '10', '127', '172', '224');
      if (in_array($addr[0], $private_addr))
        throw new Exception("address was private...");
       
      // Check the hostname is resolvable and goes to the same ip address
      $host = $location['dns'];
      $ip = gethostbyname($host);
      if (strcmp($ip, $host) === 0)
        throw new Exception("unable to resolve the host address");
       
      $port = $location['port'];
      if (!is_numeric($port))
        throw new Exception("port wasn't numeric!");
       
      if (strcmp(join($addr, '.'), $ip) !== 0)
        throw new Exception("host name didn't resolve to ip $ip address given");
       
      // Add or update this location
       
       
      $r = $db->replaceLocation($gid, $type, $host, join($addr, '.'), $location['port'] );
       
    }
     
    // Update the optional properties
    $optional = array('plys', 'cons', 'objs', 'admin', 'cmt', 'turn');
     
    foreach ($optional as $option)
    {
      if (!array_key_exists($option, $_REQUEST))
        {
        continue;
      }
       
      $db->insertOptional($gid, $option, $_REQUEST[$option] );
       
    }
    $frame = new Frame(Frame::OKAY, 1, array("message" => "metaserver - ok"));
    $pack = $frame->pack();
    echo $pack;
  } catch (Exception $e) {
  
    $frame = new Frame(Frame::FAIL, 1, array('type'=>0, 'desc'=>$e->getMessage()));
    $pack = $frame->pack();
    echo $pack;
    
  }
  
?>