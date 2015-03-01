<?php
  $userName = 'username';
  $pass = 'password';
  $DBserver = 'localhost';
  $url = "icecast url";
  $icecast_credentials = "username:password";
  
  /* Database Connection and Selection */
  $mysqlCon = mysql_connect($DBserver, $userName, $pass);
  if(!$mysqlCon){
    die('Could not connect: '.mysql_error());
  }
  
  $djLogsDB = mysql_select_db('djlogs', $mysqlCon);
  if(!$djLogsDB){
    die('Could not load database: '.mysql_error());
  }
  
  /* Get data from the table */
  $query = "select * from djlogs ORDER BY ID DESC LIMIT 1";
  $data = mysql_query($query);
  $row = mysql_fetch_assoc($data);
  
  $artist = $row['artist'];
  $song = $row['song_name'];
  
  /* Setup curl session */
  $cSesh = curl_init();
  curl_setopt( $cSesh, CURLOPT_URL, $url."admin/metadata?mount=/listen&mode=updinfo&song=".urlencode($artist." | ".$song));
  curl_setopt($cSesh, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($cSesh, CURLOPT_USERPWD, $icecast_credentials);
  
  /* Execute Curl Command */
  $result = curl_exec($cSesh);
  
  $code = curl_getinfo ($cSesh, CURLINFO_HTTP_CODE);
  $urlEf = curl_getinfo($cSesh, CURLINFO_EFFECTIVE_URL);
  
  echo $urlEf.$code.$artist.$song;
  
  curl_close($cSesh);
?>
