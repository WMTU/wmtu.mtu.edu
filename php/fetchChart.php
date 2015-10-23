<?php
  if ( isset( $_POST['key'] ) && isset( $_POST['days'] ) ) {
    // Create connection
    $configs = include('config.php');

    $con = new mysqli($configs['hostname'], $configs['username'], $configs['password'], $configs['database']);

    // Check connection
    if ($con->connect_errno){
      echo "{'Failed to connect to MySQL':'" . $con->connect_error() . "'}";
      die();
    }

    $key = filter_input(INPUT_POST, 'key', FILTER_SANITIZE_STRING);
    $days = filter_input(INPUT_POST, 'days', FILTER_SANITIZE_NUMBER_INT);
    if ( $key == 'artist' ) {
      $sql = "SELECT artist, count(artist) as 'count' FROM djlogs WHERE ts > SUBDATE(NOW(), INTERVAL ? DAY) GROUP BY artist ORDER BY count(artist) DESC LIMIT 10";
      if ( !( $stmt = $con->prepare( $sql ) ) ) {
        echo "{'Prepare failed':'" . $con->error() . "'}";
        die();
      }
      if ( !( $stmt->bind_param( "i", $days ) ) ) {
        echo "{'Binding parameters failed':'" . $con->error() . "'}";
        die();
      }
      if ( !( $stmt->execute() ) ) {
        echo "{'Execute failed':'" . $con->error() . "'}";
        die();
      }
      if ( !($stmt->bind_result( $artist, $count ) ) ) {
        echo "{'Binding results failed':'" . $con->error() . "'}";
        die();
      }
      $rows = array();
      while ( $stmt->fetch() ) {
        array_push( $rows, array(
          "artist" => $artist,
          "count" => $count
        ));
      }
      echo json_encode( $rows );
    } else {
      $sql = "SELECT artist, " . $key . ", count(" . $key . ") as 'count' FROM djlogs WHERE ts > SUBDATE(NOW(), INTERVAL ? DAY) AND " . $key . " != '' AND " . $key . " != '?' GROUP BY " . $key . ", artist ORDER BY count(" . $key . ") DESC LIMIT 10";
      if ( !( $stmt = $con->prepare( $sql ) ) ) {
        echo "{'Prepare failed':'" . $con->error() . "'}";
        die();
      }
      if ( !( $stmt->bind_param( "i", $days ) ) ) {
        echo "{'Binding parameters failed':'" . $con->error() . "'}";
        die();
      }
      if ( !( $stmt->execute() ) ) {
        echo "{'Execute failed':'" . $con->error() . "'}";
        die();
      }
      if ( !($stmt->bind_result( $artist, $resultKey, $count ) ) ) {
        echo "{'Binding results failed':'" . $con->error() . "'}";
        die();
      }
      $rows = array();
      while ( $stmt->fetch() ) {
        array_push( $rows, array(
          "artist" => $artist,
          $key => $resultKey,
          "count" => $count
        ));
      }
      echo json_encode( $rows );
    }
    $con->close();
  }
?>
