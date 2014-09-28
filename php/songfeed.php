<?php
	// Create connection
	$con=mysqli_connect("localhost","djfeed","password","djlogs");


	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$sql = "SELECT * FROM djlogs ORDER BY id DESC LIMIT 3";

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
