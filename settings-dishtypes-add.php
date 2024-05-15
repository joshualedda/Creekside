<?php 
	session_start();
	include 'connection.php';
	if (isset($_POST['submit'])) {
	
		$name = $_POST['name'];
		$main_ = $_POST['main_'];
		$weight = $_POST['weight'];

		$sql = "INSERT INTO dish_type (name,
									   main_,
									   weight)
						   	  VALUES ('$name',
								      '$main_',
								      '$weight')";
		if (mysqli_query($con, $sql)) {
			echo "
				<script = 'text/javascript>
					alert('You have successfuly added a new dish type!');
					location.href = 'settings-dishtypes.php';
				</script>
				";
		} else { echo "Error: " . $sql . "<br>" . mysqli_error($con);
			// echo "
			// 	<script = 'text/javascript>
			// 		alert('Adding new user profile was unsuccessful!');
			// 		location.href = 'settings-account.php';
			// 	</script>
			// 	";
			}

	}
?>