<?php
  // Create connection
  $configs = include('config.php');

  $con = new PDO( sprintf( 'mysql:host=%s;dbname=%s;charset=utf8',
      $configs['hostname'], $configs['database'] ),
      $configs['username'], $configs['password'] );
  $con->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  $con->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );

  if ( !$_POST['day'] | !$_POST['month'] | !$_POST['year'] ) {
    $sql = "SELECT * FROM djlogs WHERE ts > CURDATE() ORDER BY id DESC";
    $stmt = $con->prepare( $sql );
  } else {
    $day = filter_input( INPUT_POST, 'day', FILTER_SANITIZE_NUMBER_INT );
    $month = filter_input( INPUT_POST, 'month', FILTER_SANITIZE_NUMBER_INT );
    $year = filter_input( INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT );
    $date = sprintf( '%s/%s/%s', $month, $day, $year );
    $day_start = strtotime( $date . ' 00:00:00' );
    $day_end = strtotime( $date . ' 23:59:59' );

    $sql = "SELECT * FROM djlogs WHERE ts BETWEEN :start AND :end ORDER BY id DESC";
    $stmt = $con->prepare( $sql );
    $stmt->bindValue( ':start', $day_start );
    $stmt->bindValue( ':end', $day_end );
  }

  $stmt->execute();
  $rows = $stmt->fetchAll( PDO::FETCH_ASSOC );

  echo json_encode( $rows );

  $con = null;
?>
