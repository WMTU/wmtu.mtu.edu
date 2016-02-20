<?php
	$configs = include('config.php');

	// Create connection
	$con = mysqli_connect($configs['hostname'], $configs['username'], $configs['password'], $configs['database']);
	$con->set_charset("utf8");


	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$sql = "SELECT * FROM djlogs WHERE ts < DATE_SUB(NOW(), INTERVAL 30 second) ORDER BY id DESC LIMIT 3";

	// Execute query
	if ($result = mysqli_query($con,$sql))
	{
		$rows = array();
		//success
		while($assoc = mysqli_fetch_assoc($result)){
			array_push($rows, $assoc);
		}

		echo json_encode($rows);
	}
	else
	{
		echo "Error parsing data: " . mysqli_error($con);
	}

	mysqli_close($con);
?>
