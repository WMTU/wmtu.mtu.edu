<?php
  /* Load config */
  $configs = include('config.php');
  
  /* Database Connection and Selection */
  $mysql_connection = mysql_connect($configs['hostname'], $configs['username'], $configs['password'], $configs['database']);
  if(mysqli_connect_errno()){
    die('Could not connect: '.mysql_error());
  }
  
  /* Get data from the table */
  $query = "SELECT * FROM djlogs ORDER BY ID DESC LIMIT 1";
  $data = mysql_query($mysql_connection, $query);
  $row = mysql_fetch_assoc($data);
  
  $artist = $row['artist'];
  $song = $row['song_name'];
  
  /* Setup curl session */
  $cSesh = curl_init();
  curl_setopt($cSesh, CURLOPT_URL, $configs['icecast_url']."admin/metadata?mount=/listen&mode=updinfo&song=".urlencode($artist." | ".$song));
  curl_setopt($cSesh, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
  curl_setopt($cSesh, CURLOPT_USERPWD, $configs['icecast_credentials']);
  
  /* Execute Curl Command */
  $result = curl_exec($cSesh);
  
  $code = curl_getinfo ($cSesh, CURLINFO_HTTP_CODE);
  $urlEf = curl_getinfo($cSesh, CURLINFO_EFFECTIVE_URL);
  
  /* Echo out the results */
  echo $urlEf.$code.$artist.$song;
  
  curl_close($cSesh);
?>
