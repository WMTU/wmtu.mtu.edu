<?php

  /* Load config */
  $configs = include('config.php');

  require_once('TwitterAPIExchange.php');
  include("XML/Serializer.php");
  
  header('Content-Type: application/rss+xml');
  
  /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
  $settings = array(
    'oauth_access_token' => $configs['oauth_access_token'],
    'oauth_access_token_secret' => $configs['oauth_access_token_secret'],
    'consumer_key' => $configs['consumer_key'],
    'consumer_secret' => $configs['consumer_secret']
  );
  
  /** URL for REST request, see: https://dev.twitter.com/docs/api/1.1/ **/
  $url = 'https://api.twitter.com/1.1/search/tweets.json';
  $getfield = '?q=%23WMTUrequest&result_type=recent&count=3';
  $requestMethod = 'GET';
  $twitter = new TwitterAPIExchange($settings);
  
  $json = $twitter->setGetfield($getfield)
                  ->buildOauth($url, $requestMethod)
                  ->performRequest();
  $obj = json_decode($json, true);
  
  $numStatuses = count($obj["statuses"]);
  for($i = 0; $i < $numStatuses; $i++) {
    $dateString = $obj["statuses"][$i]["created_at"];
    $date = DateTime::createFromFormat("D M d H:i:s O Y", $dateString);
    $date->setTimezone(new DateTimeZone('US/Eastern'));
    $obj["statuses"][$i]["created_at"] = $date->format("M j, g:i A");
  }
  
  // An array of serializer options
  $serializerOptions = array (
    'addDecl' => false,
    'indent' => "    ",
    'linebreak' => "\n",
    'rootName' => 'item',
    'mode' => 'simplexml'
  );
  $serializer = new XML_Serializer($serializerOptions);
  $status = $serializer->serialize($obj);
  
  if (PEAR::isError($status)) die($status->getMessage());
  
  echo "<?xml version='1.0' encoding='utf-8'?>\n";
  echo "<rss version='2.0'>\n";
  echo "<channel>\n";
  echo "<title>WMTU Twitter Request Feed</title>\n";
  echo "<link>http://wmtu.mtu.edu</link>\n";
  echo "<description>The last three tweets sent with #WMTUrequest.</description>\n";
  echo "<language>en-us</language>\n";
  echo $serializer->getSerializedData();
  echo "</channel>\n";
  echo "</rss>\n";

?>
